<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('category');

        // Pencarian berdasarkan keterangan/deskripsi transaksi
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('description', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan jenis transaksi
        if (
            $request->filled('type') &&
            in_array($request->type, ['masuk', 'keluar'])
        ) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan tanggal mulai
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        // Filter berdasarkan tanggal sampai
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        // Urutan transaksi: terbaru di atas
        $transaksi = $query
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('riwayat-transaksi.index', [
            'transaksi' => $transaksi,
            'search' => $request->search,
            'type' => $request->type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);
    }
}