<?php

namespace App\Http\Controllers;

use App\Exports\RekapIuranExport;
use App\Models\Block;
use App\Models\Due;
use App\Models\Household;
use App\Models\PengajuanIuran;
use App\Models\PengajuanIuranDetail;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class VerifikasiIuranController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanIuran::with(['block', 'user'])
            ->withCount('details')
            ->where('status', 'Menunggu Verifikasi')
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

        $totalHouseholdsAktif = Household::where('block_id', $pengajuanIuran->block_id)
            ->where('is_active', true)
            ->count();

        $jumlahKKDiajukan = $pengajuanIuran->details->count();
        $kkBelumBayar = $totalHouseholdsAktif - $jumlahKKDiajukan;

        return view('verifikasi-iuran.show', compact(
            'pengajuanIuran', 'totalHouseholdsAktif', 'kkBelumBayar'
        ));
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

                        'notes' => 'Pembayaran melalui pengajuan iuran #'.
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
                'description' => 'Penerimaan iuran Blok '.
                    $pengajuan->block->name.
                    ' periode '.
                    $pengajuan->bulan.
                    '/'.
                    $pengajuan->tahun.
                    ' - Pengajuan #'.
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
            'catatan.required' => 'Alasan penolakan wajib diisi.',
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

    public function rekap(Request $request)
    {
        $month = (int) ($request->month ?? date('m'));
        $year = (int) ($request->year ?? date('Y'));
        $selectedBlockId = $request->block_id;
        $selectedStatus = $request->status;

        $blocks = Block::where('is_active', true)->orderBy('name')->get();

        $householdsQuery = Household::with('block')->where('is_active', true);
        if (!empty($selectedBlockId)) {
            $householdsQuery->where('block_id', $selectedBlockId);
        }
        $households = $householdsQuery->orderBy('block_id')->orderBy('household_number')->get();

        $paidDues = Due::where('month', $month)
            ->where('year', $year)
            ->get()
            ->keyBy('household_id');

        $pendingDetailIds = PengajuanIuranDetail::whereHas('pengajuanIuran', function ($q) use ($month, $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year)
              ->where('status', 'Menunggu Verifikasi');
        })->pluck('household_id')->toArray();

        $rekapList = [];
        $totalKK = 0;
        $lunasKK = 0;
        $menungguKK = 0;
        $belumBayarKK = 0;
        $totalNominal = 0;

        foreach ($households as $hh) {
            $due = $paidDues->get($hh->id);
            $isPending = in_array($hh->id, $pendingDetailIds);

            if ($due && $due->status === 'Lunas') {
                $status = 'Sudah Bayar';
                $tglBayar = $due->payment_date ? $due->payment_date->format('d/m/Y') : '-';
                $nominal = $due->paid_amount > 0 ? (float) $due->paid_amount : (float) $due->amount;
                $catatan = $due->notes ?? 'Lunas';
                $lunasKK++;
                $totalNominal += $nominal;
            } elseif ($isPending) {
                $status = 'Menunggu Verifikasi';
                $tglBayar = '-';
                $nominal = 0;
                $catatan = 'Dalam Pengajuan Blok';
                $menungguKK++;
            } else {
                $status = 'Belum Bayar';
                $tglBayar = '-';
                $nominal = 0;
                $catatan = 'Belum Bayar';
                $belumBayarKK++;
            }

            $totalKK++;

            // Filter by status
            if (!empty($selectedStatus)) {
                if ($selectedStatus === 'Lunas' && $status !== 'Sudah Bayar') {
                    continue;
                }
                if ($selectedStatus === 'Belum Lunas' && $status === 'Sudah Bayar') {
                    continue;
                }
                if ($selectedStatus === 'Menunggu Verifikasi' && $status !== 'Menunggu Verifikasi') {
                    continue;
                }
            }

            $rekapList[] = (object) [
                'household_id' => $hh->id,
                'block_name' => $hh->block->name ?? '-',
                'household_number' => $hh->household_number ?? '-',
                'head_name' => $hh->head_name ?? '-',
                'phone' => $hh->phone ?? '-',
                'status' => $status,
                'payment_date' => $tglBayar,
                'nominal' => $nominal,
                'notes' => $catatan,
            ];
        }

        $persentaseLunas = $totalKK > 0 ? round(($lunasKK / $totalKK) * 100, 1) : 0;

        return view('verifikasi-iuran.rekap', compact(
            'blocks',
            'rekapList',
            'month',
            'year',
            'selectedBlockId',
            'selectedStatus',
            'totalKK',
            'lunasKK',
            'menungguKK',
            'belumBayarKK',
            'totalNominal',
            'persentaseLunas'
        ));
    }

    public function exportExcel(Request $request)
    {
        $month = (int) ($request->month ?? date('m'));
        $year = (int) ($request->year ?? date('Y'));
        $blockName = 'Semua_Blok';

        if ($request->filled('block_id')) {
            $block = Block::find($request->block_id);
            if ($block) {
                $blockName = 'Blok_' . str_replace(' ', '_', $block->name);
            }
        }

        $fileName = "Rekap_Iuran_Warga_{$blockName}_{$month}_{$year}.xlsx";

        return Excel::download(new RekapIuranExport($request->all()), $fileName);
    }

    public function exportPengajuanExcel(PengajuanIuran $pengajuanIuran)
    {
        $pengajuanIuran->load(['block']);

        $filters = [
            'month' => $pengajuanIuran->bulan,
            'year' => $pengajuanIuran->tahun,
            'block_id' => $pengajuanIuran->block_id,
        ];

        $blockName = $pengajuanIuran->block ? str_replace(' ', '_', $pengajuanIuran->block->name) : 'Blok';
        $fileName = "Rekap_Iuran_Pengajuan_#{$pengajuanIuran->id}_{$blockName}_{$pengajuanIuran->bulan}_{$pengajuanIuran->tahun}.xlsx";

        return Excel::download(new RekapIuranExport($filters), $fileName);
    }
}
