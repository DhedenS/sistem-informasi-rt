<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\PengajuanIuran;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiIuranController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanIuran::with(['block', 'user'])
            ->withCount('details')
            ->latest()
            ->paginate(10);

        return view('verifikasi-iuran.index', compact('pengajuan'));
    }

    public function show(PengajuanIuran $pengajuanIuran)
    {
        $pengajuanIuran->load([
            'block',
            'user',
            'verifier',
            'details.household',
        ]);

        return view('verifikasi-iuran.show', compact('pengajuanIuran'));
    }

    public function approve(Request $request, PengajuanIuran $pengajuanIuran)
    {
        /*
         * Validasi uang yang benar-benar diterima Bendahara.
         */
        $request->validate([
            'uang_diterima' => [
                'required',
                'numeric',
                'min:0',
            ],
        ], [
            'uang_diterima.required' => 'Uang yang diterima wajib diisi.',
            'uang_diterima.numeric' => 'Uang yang diterima harus berupa angka.',
            'uang_diterima.min' => 'Uang yang diterima tidak boleh kurang dari 0.',
        ]);

        /*
         * Bandingkan uang diterima dengan total iuran
         * secara aman tanpa masalah desimal.
         */
        $uangDiterima = (int) round(
            ((float) $request->uang_diterima) * 100
        );

        $totalIuran = (int) round(
            ((float) $pengajuanIuran->total_iuran) * 100
        );

        /*
         * Uang diterima harus sama dengan total iuran.
         */
        if ($uangDiterima !== $totalIuran) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengajuan tidak dapat disetujui karena uang yang diterima tidak sesuai dengan total iuran.'
                );
        }

        DB::transaction(function () use (
            $pengajuanIuran,
            $request
        ) {
            /*
             * Lock pengajuan agar tidak diproses
             * secara bersamaan.
             */
            $pengajuan = PengajuanIuran::where(
                'id',
                $pengajuanIuran->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Cegah pengajuan yang sudah diproses
             * untuk diproses kembali.
             */
            if ($pengajuan->status !== 'Menunggu Verifikasi') {
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
             * Tandai semua KK dalam pengajuan sebagai Lunas.
             *
             * Tanggal pembayaran menggunakan created_at pengajuan,
             * bukan tanggal approval Bendahara.
             */
            foreach ($pengajuan->details as $detail) {
                Due::updateOrCreate(
                    [
                        'household_id' => $detail->household_id,
                        'month' => $pengajuan->bulan,
                        'year' => $pengajuan->tahun,
                    ],
                    [
                        'amount' => $pengajuan->nominal_per_kk,
                        'paid_amount' => $pengajuan->nominal_per_kk,
                        'status' => 'Lunas',

                        // PERBAIKAN TANGGAL
                        'payment_date' => $pengajuan->created_at,

                        'notes' =>
                            'Pembayaran melalui pengajuan iuran #' .
                            $pengajuan->id,
                    ]
                );
            }

            /*
             * Cari kategori transaksi Iuran Warga.
             */
            $category = TransactionCategory::where(
                'name',
                'Iuran Warga'
            )->firstOrFail();

            /*
             * Catat penerimaan ke cashflow.
             */
            Transaction::create([
                'transaction_date' => now()->toDateString(),
                'type' => 'masuk',
                'fund_source_id' => null,
                'transaction_category_id' => $category->id,
                'household_id' => null,
                'due_id' => null,
                'amount' => $pengajuan->total_iuran,
                'description' =>
                    'Penerimaan iuran Blok ' .
                    $pengajuan->block->name .
                    ' periode ' .
                    $pengajuan->bulan .
                    '/' .
                    $pengajuan->tahun .
                    ' - Pengajuan #' .
                    $pengajuan->id,
                'proof_file' => $pengajuan->bukti,
                'user_id' => auth()->id(),
            ]);

            /*
             * Simpan hasil verifikasi.
             */
            $pengajuan->update([
                'uang_diterima' => $request->uang_diterima,
                'status' => 'Disetujui',
                'diverifikasi_oleh' => auth()->id(),
                'diverifikasi_pada' => now(),
            ]);
        });

        return redirect()
            ->route('verifikasi-iuran.index')
            ->with(
                'success',
                'Pengajuan iuran berhasil disetujui dan dicatat ke cashflow.'
            );
    }

    public function reject(
        Request $request,
        PengajuanIuran $pengajuanIuran
    ) {
        /*
         * Pastikan pengajuan masih menunggu verifikasi.
         */
        if ($pengajuanIuran->status !== 'Menunggu Verifikasi') {
            return back()->with(
                'error',
                'Pengajuan ini sudah diproses sebelumnya.'
            );
        }

        /*
         * Alasan penolakan wajib diisi.
         */
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

        /*
         * Simpan hasil penolakan.
         */
        $pengajuanIuran->update([
            'status' => 'Ditolak',
            'catatan' => $request->catatan,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);

        return redirect()
            ->route('verifikasi-iuran.index')
            ->with(
                'success',
                'Pengajuan iuran berhasil ditolak.'
            );
    }
}