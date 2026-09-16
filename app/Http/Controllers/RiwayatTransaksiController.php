<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaction::with('category')
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15);

        return view('riwayat-transaksi.index', compact('transaksi'));
    }
}