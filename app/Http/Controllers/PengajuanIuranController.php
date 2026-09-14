<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Household;
use App\Models\Approval;
use App\Models\PengajuanIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanIuranController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $pengajuan = PengajuanIuran::with([
            'block',
            'details.household',
            'approval',
        ])
            ->where('block_id', $user->block_id)
            ->latest()
            ->paginate(10);

        return view(
            'pengajuan-iuran.index',
            compact('pengajuan')
        );
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user->block_id) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Akun Ketua Block belum memiliki blok.'
                );
        }

        $households = Household::where(
            'block_id',
            $user->block_id
        )
            ->where('is_active', true)
            ->orderBy('household_number')
            ->get();

        $block = Block::findOrFail($user->block_id);

        $nominalPerKK = 30000;

        return view(
            'pengajuan-iuran.create',
            compact(
                'households',
                'block',
                'nominalPerKK'
            )
        );
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->block_id) {
            return back()->with(
                'error',
                'Akun Anda belum memiliki blok.'
            );
        }

        $request->validate([
            'bulan' => [
                'required',
                'integer',
                'between:1,12',
            ],

            'tahun' => [
                'required',
                'integer',
                'min:2024',
                'max:2100',
            ],

            'household_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'household_ids.*' => [
                'required',
                'integer',
                'exists:households,id',
            ],

            'bukti' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'household_ids.required' =>
                'Pilih minimal satu KK yang sudah membayar.',

            'household_ids.min' =>
                'Pilih minimal satu KK yang sudah membayar.',

            'bukti.mimes' =>
                'Bukti harus berupa JPG, JPEG, PNG, atau PDF.',

            'bukti.max' =>
                'Ukuran bukti maksimal 5 MB.',
        ]);

        $households = Household::whereIn(
            'id',
            $request->household_ids
        )
            ->where('block_id', $user->block_id)
            ->where('is_active', true)
            ->get();

        if (
            $households->count()
            !== count($request->household_ids)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'household_ids' =>
                        'Terdapat KK yang bukan bagian dari blok Anda.',
                ]);
        }

        /*
         * Cegah KK yang sama diajukan dua kali
         * pada bulan dan tahun yang sama.
         */
        $sudahDiajukan = PengajuanIuran::where(
            'block_id',
            $user->block_id
        )
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->whereIn(
                'status',
                [
                    'Menunggu Verifikasi',
                    'Disetujui',
                ]
            )
            ->whereHas(
                'details',
                function ($query) use ($households) {
                    $query->whereIn(
                        'household_id',
                        $households->pluck('id')
                    );
                }
            )
            ->exists();

        if ($sudahDiajukan) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terdapat KK yang sudah diajukan pada periode tersebut.'
                );
        }

        $nominalPerKK = 30000;

        $jumlahKK = $households->count();

        $totalIuran =
            $jumlahKK * $nominalPerKK;

        DB::transaction(function () use (
            $request,
            $user,
            $households,
            $nominalPerKK,
            $totalIuran
        ) {
            $buktiPath = null;

            if ($request->hasFile('bukti')) {
                $buktiPath = $request
                    ->file('bukti')
                    ->store(
                        'pengajuan-iuran',
                        'public'
                    );
            }

            /*
             * Buat pengajuan iuran.
             */
            $pengajuan = PengajuanIuran::create([
                'block_id' =>
                    $user->block_id,

                'user_id' =>
                    $user->id,

                'bulan' =>
                    $request->bulan,

                'tahun' =>
                    $request->tahun,

                'nominal_per_kk' =>
                    $nominalPerKK,

                'total_iuran' =>
                    $totalIuran,

                'bukti' =>
                    $buktiPath,

                'status' =>
                    'Menunggu Verifikasi',

                'catatan' =>
                    $request->catatan,
            ]);

            /*
             * Simpan daftar KK yang membayar.
             */
            foreach ($households as $household) {
                $pengajuan
                    ->details()
                    ->create([
                        'household_id' =>
                            $household->id,
                    ]);
            }

            /*
             * =====================================================
             * BAGIAN KATEGORI 4
             * Otomatis membuat Approval.
             * =====================================================
             */

            $approval = $pengajuan
                ->approval()
                ->create([
                    'user_id' =>
                        $user->id,

                    'status' =>
                        Approval::STATUS_PENDING,

                    'notes' =>
                        $request->catatan,

                    'acted_at' =>
                        now(),
                ]);

            /*
             * Audit Trail pertama:
             * Ketua Block mengajukan iuran.
             */
            $approval
                ->histories()
                ->create([
                    'user_id' =>
                        $user->id,

                    'action' =>
                        'submit',

                    'from_status' =>
                        null,

                    'to_status' =>
                        Approval::STATUS_PENDING,

                    'notes' =>
                        $request->catatan
                            ?: 'Ketua Block mengajukan iuran.',

                    'acted_at' =>
                        now(),
                ]);
        });

        return redirect()
            ->route('pengajuan-iuran.index')
            ->with(
                'success',
                'Pengajuan iuran berhasil dikirim dan menunggu verifikasi Bendahara.'
            );
    }

    public function show(
        PengajuanIuran $pengajuanIuran
    ) {
        $user = auth()->user();

        if (
            $pengajuanIuran->block_id
            !== $user->block_id
        ) {
            abort(403);
        }

        $pengajuanIuran->load([
            'block',
            'user',
            'verifier',
            'details.household',
            'approval.histories.user',
        ]);

        return view(
            'pengajuan-iuran.show',
            compact('pengajuanIuran')
        );
    }
}