<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Household;
use App\Models\IuranRate;
use App\Models\PengajuanIuran;
use App\Models\PengajuanIuranDetail;
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
            ->where('status', 'Menunggu Verifikasi')
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

        if (! $user->block_id) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Ketua Block belum memiliki blok.');
        }

        $households = Household::where('block_id', $user->block_id)
            ->where('is_active', true)
            ->orderBy('household_number')
            ->get();

        $block = Block::find($user->block_id);
        $nominalPerKK = 30000;
        $iuranRates = IuranRate::orderBy('year')->orderBy('month')->get();

        // Peta KK yang sudah bayar: ["2026-10" => [1, 2, 5], ...]
        $statusAktif = ['Menunggu Verifikasi', 'Disetujui'];

        $paidMap = PengajuanIuran::with('details')
            ->where('block_id', $user->block_id)
            ->whereIn('status', $statusAktif)
            ->get()
            ->groupBy(fn ($p) => $p->tahun.'-'.(int) $p->bulan)
            ->map(fn ($group) => $group
                ->flatMap(fn ($p) => $p->details->pluck('household_id'))
                ->unique()
                ->values()
            );

        return view('pengajuan-iuran.create', compact(
            'households', 'block', 'nominalPerKK', 'iuranRates', 'paidMap'
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
                    'household_ids' => 'Terdapat KK yang bukan bagian dari blok Anda.',
                ]);
        }

        // Cegah KK yang sudah diajukan/dibayar untuk periode ini
        $sudahBayarIds = PengajuanIuranDetail::whereIn('household_id', $request->household_ids)
            ->whereHas('pengajuanIuran', function ($q) use ($request, $user) {
                $q->where('block_id', $user->block_id)
                    ->where('bulan', $request->bulan)
                    ->where('tahun', $request->tahun)
                    ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui']);
            })
            ->pluck('household_id');

        if ($sudahBayarIds->isNotEmpty()) {
            return back()
                ->withInput()
                ->withErrors([
                    'household_ids' => 'Ada KK yang sudah membayar/diajukan untuk periode ini. Muat ulang halaman.',
                ]);
        }

        $nominalPerKK = IuranRate::getRateFor($request->bulan, $request->tahun);
        $jumlahKK = $households->count();
        $totalIuran = $jumlahKK * $nominalPerKK;

        $totalHouseholdsAktif = Household::where('block_id', $user->block_id)
            ->where('is_active', true)
            ->count();

        $sudahBayarPeriode = PengajuanIuranDetail::whereHas('pengajuanIuran', function ($q) use ($request, $user) {
            $q->where('block_id', $user->block_id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->whereIn('status', ['Menunggu Verifikasi', 'Disetujui']);
        })
            ->distinct('household_id')
            ->count('household_id');

        $kkBelumBayar = $totalHouseholdsAktif - $sudahBayarPeriode - $jumlahKK;

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

        $pesanTambahan = $kkBelumBayar > 0
            ? " ({$kkBelumBayar} KK belum membayar dari total {$totalHouseholdsAktif} KK)"
            : '';

        return redirect()
            ->route('pengajuan-iuran.index')
            ->with('success', 'Pengajuan iuran berhasil dikirim dan menunggu verifikasi Bendahara.'.$pesanTambahan);
    }

    /**
     * Menampilkan detail pengajuan.
     */
    public function show(PengajuanIuran $pengajuanIuran)
    {
        $user = auth()->user();

        if ($pengajuanIuran->block_id !== $user->block_id) {
            abort(403);
        }

        $pengajuanIuran->load([
            'block',
            'user',
            'verifier',
            'details.household',
        ]);

        // ID household yang sudah diajukan
        $householdIdsDiajukan = $pengajuanIuran->details->pluck('household_id');

        // KK yang belum diajukan/belum bayar
        $householdsBelumBayar = Household::where('block_id', $pengajuanIuran->block_id)
            ->where('is_active', true)
            ->whereNotIn('id', $householdIdsDiajukan)
            ->orderBy('household_number')
            ->get();

        return view('pengajuan-iuran.show', compact(
            'pengajuanIuran', 'householdsBelumBayar'
        ));
    }

    public function cancel(PengajuanIuran $pengajuanIuran)
    {
        $user = auth()->user();

        if ($pengajuanIuran->block_id !== $user->block_id) {
            abort(403);
        }

        if ($pengajuanIuran->status !== 'Menunggu Verifikasi') {
            return back()->with('error', 'Hanya pengajuan yang masih menunggu verifikasi yang dapat dibatalkan.');
        }

        $pengajuanIuran->delete();

        return redirect()
            ->route('pengajuan-iuran.index')
            ->with('success', 'Pengajuan iuran berhasil dibatalkan.');
    }
}
