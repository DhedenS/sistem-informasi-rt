<?php

namespace App\Http\Controllers;

use App\Models\Due;

class IuranSayaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Pastikan akun Warga sudah terhubung dengan data KK
        if (!$user->household_id) {
            return view('iuran-saya.index', [
                'dues' => collect(),
                'household' => null,
            ])->with('error', 'Akun Anda belum terhubung dengan data KK.');
        }

        // Ambil data KK milik Warga yang sedang login
        $household = $user->household;

        // Ambil hanya iuran milik KK tersebut
        $dues = Due::where('household_id', $user->household_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->paginate(12);

        return view('iuran-saya.index', compact('dues', 'household'));
    }
}