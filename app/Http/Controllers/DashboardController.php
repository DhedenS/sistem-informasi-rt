<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Due;
use App\Models\Household;
use App\Models\Transaction;
use App\Models\SuratMasuk;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data jumlah
        $totalKK = Household::where('is_active', true)->count();
        $totalBlok = Block::count();
        $totalSuratMasuk = SuratMasuk::count();

        // Data iuran
        $iuranLunas = Due::where('status', 'Lunas')->count();
        $iuranBelumLunas = Due::where('status', 'Belum Lunas')->count();

        // Data keuangan
        $totalPemasukan = Transaction::where('type', 'masuk')->sum('amount');
        $totalPengeluaran = Transaction::where('type', 'keluar')->sum('amount');
        $saldoKas = $totalPemasukan - $totalPengeluaran;

        // Transaksi terbaru
        $transaksiTerbaru = Transaction::with(['category', 'user'])
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get();

        // Surat masuk terbaru
        $suratTerbaru = SuratMasuk::latest()
            ->take(5)
            ->get();

        // Cashflow 6 bulan terakhir
        $cashflowData = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            $masuk = Transaction::where('type', 'masuk')
                ->whereMonth('transaction_date', $bulan->month)
                ->whereYear('transaction_date', $bulan->year)
                ->sum('amount');

            $keluar = Transaction::where('type', 'keluar')
                ->whereMonth('transaction_date', $bulan->month)
                ->whereYear('transaction_date', $bulan->year)
                ->sum('amount');

            $cashflowData[] = [
                'label' => $bulan->translatedFormat('M'),
                'masuk' => $masuk,
                'keluar' => $keluar,
            ];
        }

        $maxValue = collect($cashflowData)->max(function ($item) {
            return max($item['masuk'], $item['keluar']);
        });

        return view('dashboard', compact(
            'totalKK',
            'totalBlok',
            'totalSuratMasuk',
            'iuranLunas',
            'iuranBelumLunas',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoKas',
            'transaksiTerbaru',
            'suratTerbaru',
            'cashflowData',
            'maxValue'
        ));
    }
}