<?php

namespace App\Http\Controllers;

use App\Models\FundSource;
use App\Models\Household;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['fundSource', 'category', 'household', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('transaction_category_id', $request->category_id);
        }

        if ($request->filled('fund_source_id')) {
            $query->where('fund_source_id', $request->fund_source_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->latest('id')->paginate(15)->withQueryString();

        // Calculate Realtime Cash Balance
        $totalIncome = Transaction::where('type', 'masuk')->sum('amount');
        $totalExpense = Transaction::where('type', 'keluar')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $categories = TransactionCategory::where('is_active', true)->get();
        $fundSources = FundSource::where('is_active', true)->get();

        return view('cashflow.transactions.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'categories',
            'fundSources'
        ));
    }

    public function createIncome()
    {
        $fundSources = FundSource::where('is_active', true)->get();
        $categories = TransactionCategory::where('type', 'masuk')->where('is_active', true)->get();
        $households = Household::where('is_active', true)->with('block')->get();

        return view('cashflow.transactions.create-income', compact('fundSources', 'categories', 'households'));
    }

    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'fund_source_id' => 'required|exists:fund_sources,id',
            'transaction_category_id' => 'required|exists:transaction_categories,id',
            'household_id' => 'nullable|exists:households,id',
            'amount' => 'required|numeric|gt:0',
            'description' => 'nullable|string',
            'proof_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Ensure category is of type 'masuk'
        $category = TransactionCategory::findOrFail($validated['transaction_category_id']);
        if ($category->type !== 'masuk') {
            return back()->withErrors(['transaction_category_id' => 'Kategori yang dipilih harus bertipe Pemasukan (masuk).'])->withInput();
        }

        DB::transaction(function () use ($request, $validated) {
            $proofPath = null;
            if ($request->hasFile('proof_file')) {
                $file = $request->file('proof_file');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $proofPath = $file->storeAs('proofs', $filename, 'public');
            }

            Transaction::create([
                'transaction_date' => $validated['transaction_date'],
                'type' => 'masuk',
                'fund_source_id' => $validated['fund_source_id'],
                'transaction_category_id' => $validated['transaction_category_id'],
                'household_id' => $validated['household_id'] ?? null,
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
                'proof_file' => $proofPath,
                'user_id' => auth()->id(),
            ]);
        });

        return redirect()->route('cashflow.transactions.index')->with('success', 'Pemasukan berhasil dicatat.');
    }

    public function createExpense()
    {
        $categories = TransactionCategory::where('type', 'keluar')->where('is_active', true)->get();

        return view('cashflow.transactions.create-expense', compact('categories'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'transaction_category_id' => 'required|exists:transaction_categories,id',
            'amount' => 'required|numeric|gt:0',
            'description' => 'nullable|string',
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Mandatory for expense per requirement
        ]);

        // Ensure category is of type 'keluar'
        $category = TransactionCategory::findOrFail($validated['transaction_category_id']);
        if ($category->type !== 'keluar') {
            return back()->withErrors(['transaction_category_id' => 'Kategori yang dipilih harus bertipe Pengeluaran (keluar).'])->withInput();
        }

        DB::transaction(function () use ($request, $validated) {
            $file = $request->file('proof_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $proofPath = $file->storeAs('proofs', $filename, 'public');

            Transaction::create([
                'transaction_date' => $validated['transaction_date'],
                'type' => 'keluar',
                'fund_source_id' => null,
                'transaction_category_id' => $validated['transaction_category_id'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
                'proof_file' => $proofPath,
                'user_id' => auth()->id(),
            ]);
        });

        return redirect()->route('cashflow.transactions.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['fundSource', 'category', 'household.block', 'user', 'due']);
        return view('cashflow.transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            if ($transaction->proof_file && Storage::disk('public')->exists($transaction->proof_file)) {
                Storage::disk('public')->delete($transaction->proof_file);
            }

            // If linked to a due, update due status back to 'Belum Lunas'
            if ($transaction->due_id && $transaction->due) {
                $transaction->due->update([
                    'status' => 'Belum Lunas',
                    'paid_amount' => 0,
                    'payment_date' => null,
                ]);
            }

            $transaction->delete();
        });

        return redirect()->route('cashflow.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
