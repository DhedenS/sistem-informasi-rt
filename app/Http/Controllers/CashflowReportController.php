<?php

namespace App\Http\Controllers;

use App\Exports\CashflowReportExport;
use App\Models\Block;
use App\Models\FundSource;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CashflowReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['fundSource', 'category', 'household.block', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('transaction_category_id', $request->category_id);
        }

        if ($request->filled('fund_source_id')) {
            $query->where('fund_source_id', $request->fund_source_id);
        }

        if ($request->filled('block_id')) {
            $query->whereHas('household', function ($q) use ($request) {
                $q->where('block_id', $request->block_id);
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        // Clone query for metrics before pagination
        $summaryQuery = clone $query;
        $totalIncome = (clone $summaryQuery)->where('type', 'masuk')->sum('amount');
        $totalExpense = (clone $summaryQuery)->where('type', 'keluar')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(20)->withQueryString();

        $categories = TransactionCategory::where('is_active', true)->get();
        $fundSources = FundSource::where('is_active', true)->get();
        $blocks = Block::where('is_active', true)->get();

        return view('cashflow.reports.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'categories',
            'fundSources',
            'blocks'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['fundSource', 'category', 'household.block', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('transaction_category_id', $request->category_id);
        }

        if ($request->filled('fund_source_id')) {
            $query->where('fund_source_id', $request->fund_source_id);
        }

        if ($request->filled('block_id')) {
            $query->whereHas('household', function ($q) use ($request) {
                $q->where('block_id', $request->block_id);
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        $totalIncome = $transactions->where('type', 'masuk')->sum('amount');
        $totalExpense = $transactions->where('type', 'keluar')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView('cashflow.reports.pdf', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'request'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Cashflow_RT_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['type', 'category_id', 'fund_source_id', 'block_id', 'start_date', 'end_date']);
        return Excel::download(new CashflowReportExport($filters), 'Laporan_Cashflow_RT_' . date('Y-m-d') . '.xlsx');
    }
}
