<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\Approval;
use App\Models\PengajuanIuran;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiIuranController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanIuran::with([
            'block',
            'user',
            'approval',
        ])
            ->withCount('details')
            ->latest()
            ->paginate(10);

        return view(
            'verifikasi-iuran.index',
            compact('pengajuan')
        );
    }

    public function show(
        PengajuanIuran $pengajuanIuran
    ) {
        $pengajuanIuran->load([
            'block',
            'user',
            'verifier',
            'details.household',
            'approval.histories.user',
        ]);

        return view(
            'verifikasi-iuran.show',
            compact('pengajuanIuran')
        );
    }

    public function approve(
        Request $request,
        PengajuanIuran $pengajuanIuran
    ) {
        $request->validate([
            'uang_diterima' => [
                'required',
                'numeric',
                'min:0',
            ],
        ], [
            'uang_diterima.required' =>
                'Uang yang diterima wajib diisi.',

            'uang_diterima.numeric' =>
                'Uang yang diterima harus berupa angka.',

            'uang_diterima.min' =>
                'Uang yang diterima tidak boleh kurang dari 0.',
        ]);

        /*
         * Karena nominal iuran kita menggunakan rupiah,
         * bulatkan sebelum dibandingkan.
         */
        $uangDiterima = (int) round(
            (float) $request->uang_diterima
        );

        $totalIuran = (int) round(
            (float) $pengajuanIuran->total_iuran
        );

        /*
         * Validasi otomatis.
         */
        if ($uangDiterima !== $totalIuran) {
            $selisih =
                $uangDiterima - $totalIuran;

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Nominal tidak sesuai. Selisih Rp ' .
                    number_format(
                        abs($selisih),
                        0,
                        ',',
                        '.'
                    )
                );
        }

        DB::transaction(function () use (
            $pengajuanIuran,
            $request
        ) {
            /*
             * Lock agar tidak bisa diproses
             * dua kali bersamaan.
             */
            $pengajuan = PengajuanIuran::where(
                'id',
                $pengajuanIuran->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $pengajuan->status
                !== 'Menunggu Verifikasi'
            ) {
                abort(
                    409,
                    'Pengajuan ini sudah diproses sebelumnya.'
                );
            }

            $pengajuan->load([
                'details.household',
                'block',
            ]);

            /*
             * =====================================================
             * Tandai iuran KK sebagai LUNAS
             * =====================================================
             */

            foreach (
                $pengajuan->details
                as $detail
            ) {
                Due::updateOrCreate(
                    [
                        'household_id' =>
                            $detail->household_id,

                        'month' =>
                            $pengajuan->bulan,

                        'year' =>
                            $pengajuan->tahun,
                    ],
                    [
                        'amount' =>
                            $pengajuan->nominal_per_kk,

                        'paid_amount' =>
                            $pengajuan->nominal_per_kk,

                        'status' =>
                            'Lunas',

                        'payment_date' =>
                            now(),

                        'notes' =>
                            'Pembayaran melalui pengajuan iuran #' .
                            $pengajuan->id,
                    ]
                );
            }

            /*
             * =====================================================
             * MASUK CASHFLOW
             * =====================================================
             */

            $category =
                TransactionCategory::where(
                    'name',
                    'Iuran Warga'
                )
                ->firstOrFail();

            Transaction::create([
                'transaction_date' =>
                    now()->toDateString(),

                'type' =>
                    'masuk',

                'fund_source_id' =>
                    null,

                'transaction_category_id' =>
                    $category->id,

                'household_id' =>
                    null,

                'due_id' =>
                    null,

                'amount' =>
                    $pengajuan->total_iuran,

                'description' =>
                    'Penerimaan iuran Blok ' .
                    $pengajuan->block->name .
                    ' periode ' .
                    $pengajuan->bulan .
                    '/' .
                    $pengajuan->tahun .
                    ' - Pengajuan #' .
                    $pengajuan->id,

                'proof_file' =>
                    $pengajuan->bukti,

                'user_id' =>
                    auth()->id(),
            ]);

            /*
             * Update PengajuanIuran.
             */
            $pengajuan->update([
                'uang_diterima' =>
                    $request->uang_diterima,

                'status' =>
                    'Disetujui',

                'diverifikasi_oleh' =>
                    auth()->id(),

                'diverifikasi_pada' =>
                    now(),
            ]);

            /*
             * =====================================================
             * KATEGORI 4 - APPROVAL
             * =====================================================
             */

            $approval = Approval::firstOrCreate(
                [
                    'approvable_type' =>
                        PengajuanIuran::class,

                    'approvable_id' =>
                        $pengajuan->id,
                ],
                [
                    'user_id' =>
                        $pengajuan->user_id,

                    'status' =>
                        Approval::STATUS_PENDING,

                    'notes' =>
                        $pengajuan->catatan,

                    'acted_at' =>
                        $pengajuan->created_at,
                ]
            );

            $oldStatus =
                $approval->status;

            $approval->update([
                'status' =>
                    Approval::STATUS_APPROVED,

                'notes' =>
                    'Nominal telah sesuai dengan total tagihan.',

                'acted_at' =>
                    now(),
            ]);

            /*
             * Audit Trail.
             */
            $approval
                ->histories()
                ->create([
                    'user_id' =>
                        auth()->id(),

                    'action' =>
                        'approve',

                    'from_status' =>
                        $oldStatus,

                    'to_status' =>
                        Approval::STATUS_APPROVED,

                    'notes' =>
                        'Uang diterima Rp ' .
                        number_format(
                            $request->uang_diterima,
                            0,
                            ',',
                            '.'
                        ) .
                        ' sesuai dengan total iuran.',

                    'acted_at' =>
                        now(),
                ]);
        });

        return redirect()
            ->route('verifikasi-iuran.index')
            ->with(
                'success',
                'Pengajuan berhasil disetujui dan masuk ke cashflow.'
            );
    }

    public function reject(
        Request $request,
        PengajuanIuran $pengajuanIuran
    ) {
        $request->validate([
            'catatan' => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            'catatan.required' =>
                'Alasan penolakan wajib diisi.',
        ]);

        DB::transaction(function () use (
            $request,
            $pengajuanIuran
        ) {
            $pengajuan =
                PengajuanIuran::where(
                    'id',
                    $pengajuanIuran->id
                )
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $pengajuan->status
                !== 'Menunggu Verifikasi'
            ) {
                abort(
                    409,
                    'Pengajuan ini sudah diproses sebelumnya.'
                );
            }

            $pengajuan->update([
                'status' =>
                    'Ditolak',

                'catatan' =>
                    $request->catatan,

                'diverifikasi_oleh' =>
                    auth()->id(),

                'diverifikasi_pada' =>
                    now(),
            ]);

            /*
             * Sinkronkan Approval.
             */
            $approval = Approval::firstOrCreate(
                [
                    'approvable_type' =>
                        PengajuanIuran::class,

                    'approvable_id' =>
                        $pengajuan->id,
                ],
                [
                    'user_id' =>
                        $pengajuan->user_id,

                    'status' =>
                        Approval::STATUS_PENDING,

                    'notes' =>
                        null,

                    'acted_at' =>
                        $pengajuan->created_at,
                ]
            );

            $oldStatus =
                $approval->status;

            $approval->update([
                'status' =>
                    Approval::STATUS_REJECTED,

                'notes' =>
                    $request->catatan,

                'acted_at' =>
                    now(),
            ]);

            /*
             * Audit Trail.
             */
            $approval
                ->histories()
                ->create([
                    'user_id' =>
                        auth()->id(),

                    'action' =>
                        'reject',

                    'from_status' =>
                        $oldStatus,

                    'to_status' =>
                        Approval::STATUS_REJECTED,

                    'notes' =>
                        $request->catatan,

                    'acted_at' =>
                        now(),
                ]);
        });

        return redirect()
            ->route('verifikasi-iuran.index')
            ->with(
                'success',
                'Pengajuan iuran berhasil ditolak.'
            );
    }
}