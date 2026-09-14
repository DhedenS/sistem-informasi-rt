<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\FundSource;
use App\Models\Household;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DueController extends Controller
{
    public function index(Request $request)
    {
        $query = Due::with(['household.block', 'transaction']);

        if ($request->filled('household_id')) {
            $query->where('household_id', $request->household_id);
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dues = $query->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(15)
            ->withQueryString();

        $households = Household::where('is_active', true)->with('block')->get();

        return view('cashflow.dues.index', compact('dues', 'households'));
    }

    public function create()
    {
        $households = Household::where('is_active', true)->with('block')->get();
        return view('cashflow.dues.create', compact('households'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target' => 'required|in:single,all',
            'household_id' => 'required_if:target,single|nullable|exists:households,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2020|max:2099',
            'amount' => 'required|numeric|gt:0',
            'notes' => 'nullable|string',
        ]);

        $month = (int)$request->month;
        $year = (int)$request->year;
        $amount = $request->amount;
        $notes = $request->notes;

        DB::transaction(function () use ($request, $month, $year, $amount, $notes) {
            if ($request->target === 'single') {
                Due::updateOrCreate(
                    [
                        'household_id' => $request->household_id,
                        'month' => $month,
                        'year' => $year,
                    ],
                    [
                        'amount' => $amount,
                        'notes' => $notes,
                    ]
                );
            } else {
                $households = Household::where('is_active', true)->get();
                foreach ($households as $hh) {
                    Due::firstOrCreate(
                        [
                            'household_id' => $hh->id,
                            'month' => $month,
                            'year' => $year,
                        ],
                        [
                            'amount' => $amount,
                            'notes' => $notes,
                            'status' => 'Belum Lunas',
                            'paid_amount' => 0,
                        ]
                    );
                }
            }
        });

        return redirect()->route('cashflow.dues.index')->with('success', 'Tagihan iuran berhasil dibuat.');
    }

    public function pay(Request $request, Due $due)
    {
        if ($due->status === 'Lunas') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        $request->validate([
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($due, $request) {
            $paymentDate = $request->payment_date;

            // Find or create Category 'Iuran Warga'
            $category = TransactionCategory::firstOrCreate(
                ['name' => 'Iuran Warga', 'type' => 'masuk'],
                ['is_active' => true]
            );

            // Find or create FundSource 'Iuran Warga'
            $fundSource = FundSource::firstOrCreate(
                ['name' => 'Iuran Warga'],
                ['description' => 'Rutin/bulanan', 'is_active' => true]
            );

            // 1. Update Due Status
            $due->update([
                'status' => 'Lunas',
                'paid_amount' => $due->amount,
                'payment_date' => $paymentDate,
                'notes' => $request->notes ?? $due->notes,
            ]);

            // 2. Automatically record Cashflow Income Transaction
            Transaction::create([
                'transaction_date' => $paymentDate,
                'type' => 'masuk',
                'fund_source_id' => $fundSource->id,
                'transaction_category_id' => $category->id,
                'household_id' => $due->household_id,
                'due_id' => $due->id,
                'amount' => $due->amount,
                'description' => "Pembayaran Iuran Warga KK {$due->household->head_name} Periode {$due->month_name} {$due->year}",
                'proof_file' => null,
                'user_id' => auth()->id(),
            ]);
        });

        return redirect()->route('cashflow.dues.index')->with('success', "Pembayaran iuran KK {$due->household->head_name} berhasil dicatat.");
    }
}
