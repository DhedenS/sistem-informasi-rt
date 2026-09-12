<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Household;
use App\Models\PengajuanIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanIuranController extends Controller
{
    /**
     * Menampilkan daftar pengajuan iuran milik Ketua Block.
     */
    public function index()
    {
        $user = auth()->user();

        $pengajuan = PengajuanIuran::with(['block', 'details.household'])
            ->where('block_id', $user->block_id)
            ->latest()
            ->paginate(10);

        return view('pengajuan-iuran.index', compact('pengajuan'));
    }

    /**
     * Menampilkan form membuat pengajuan iuran.
     */
    public function create()
    {
        $user = auth()->user();

        // Pastikan Ketua Block sudah memiliki blok
        if (!$user->block_id) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Akun Ketua Block belum memiliki blok.');
        }

        // Hanya mengambil KK dari blok Ketua Block yang sedang login
        $households = Household::where('block_id', $user->block_id)
            ->where('is_active', true)
            ->orderBy('household_number')
            ->get();

        $block = Block::find($user->block_id);

        // Nominal tetap sesuai ketentuan sistem
        $nominalPerKK = 30000;

        return view('pengajuan-iuran.create', compact(
            'households',
            'block',
            'nominalPerKK'
        ));
    }

    /**
     * Menyimpan pengajuan iuran.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'bulan' => ['required', 'integer', 'between:1,12'],
            'tahun' => ['required', 'integer', 'min:2024', 'max:2100'],
            'household_ids' => ['required', 'array', 'min:1'],
            'household_ids.*' => ['required', 'integer', 'exists:households,id'],
            'bukti' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'household_ids.required' => 'Pilih minimal satu KK yang sudah membayar.',
            'household_ids.min' => 'Pilih minimal satu KK yang sudah membayar.',
            'bukti.mimes' => 'Bukti harus berupa JPG, JPEG, PNG, atau PDF.',
            'bukti.max' => 'Ukuran bukti maksimal 5 MB.',
        ]);

        // Pastikan semua KK yang dipilih memang berada
        // di blok milik Ketua Block
        $households = Household::whereIn('id', $request->household_ids)
            ->where('block_id', $user->block_id)
            ->where('is_active', true)
            ->get();

        if ($households->count() !== count($request->household_ids)) {
            return back()
                ->withInput()
                ->withErrors([
                    'household_ids' => 'Terdapat KK yang bukan bagian dari blok Anda.'
                ]);
        }

        $nominalPerKK = 30000;
        $jumlahKK = $households->count();
        $totalIuran = $jumlahKK * $nominalPerKK;

        DB::transaction(function () use (
            $request,
            $user,
            $households,
            $nominalPerKK,
            $totalIuran
        ) {
            $buktiPath = null;

            if ($request->hasFile('bukti')) {
                $buktiPath = $request->file('bukti')
                    ->store('pengajuan-iuran', 'public');
            }

            $pengajuan = PengajuanIuran::create([
                'block_id' => $user->block_id,
                'user_id' => $user->id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'nominal_per_kk' => $nominalPerKK,
                'total_iuran' => $totalIuran,
                'bukti' => $buktiPath,
                'status' => 'Menunggu Verifikasi',
                'catatan' => $request->catatan,
            ]);

            foreach ($households as $household) {
                $pengajuan->details()->create([
                    'household_id' => $household->id,
                ]);
            }
        });

        return redirect()
            ->route('pengajuan-iuran.index')
            ->with('success', 'Pengajuan iuran berhasil dikirim dan menunggu verifikasi Bendahara.');
    }

    /**
     * Menampilkan detail pengajuan.
     */
    public function show(PengajuanIuran $pengajuanIuran)
    {
        $user = auth()->user();

        // Ketua Block hanya boleh melihat pengajuan bloknya sendiri
        if ($pengajuanIuran->block_id !== $user->block_id) {
            abort(403);
        }

        $pengajuanIuran->load([
            'block',
            'user',
            'verifier',
            'details.household'
        ]);

        return view('pengajuan-iuran.show', compact('pengajuanIuran'));
    }
}