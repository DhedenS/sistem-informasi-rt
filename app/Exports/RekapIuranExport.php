<?php

namespace App\Exports;

use App\Models\Household;
use App\Models\Due;
use App\Models\PengajuanIuranDetail;
use App\Models\Block;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RekapIuranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected array $filters;
    private int $rowNumber = 0;
    protected string $monthName = '';

    public function __construct(array $filters = [])
    {
        $this->filters = [
            'month' => (int) ($filters['month'] ?? date('m')),
            'year' => (int) ($filters['year'] ?? date('Y')),
            'block_id' => $filters['block_id'] ?? null,
            'status' => $filters['status'] ?? null,
        ];

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $this->monthName = $months[$this->filters['month']] ?? '';
    }

    public function title(): string
    {
        return 'Rekap Iuran ' . $this->monthName . ' ' . $this->filters['year'];
    }

    public function collection(): Collection
    {
        $month = $this->filters['month'];
        $year = $this->filters['year'];
        $blockId = $this->filters['block_id'];
        $filterStatus = $this->filters['status'];

        // Get households query
        $householdsQuery = Household::with('block')
            ->where('is_active', true);

        if (!empty($blockId)) {
            $householdsQuery->where('block_id', $blockId);
        }

        $households = $householdsQuery->orderBy('block_id')->orderBy('household_number')->get();

        // Get paid dues for this period
        $paidDues = Due::where('month', $month)
            ->where('year', $year)
            ->get()
            ->keyBy('household_id');

        // Get pending submission details for this period
        $pendingDetailIds = PengajuanIuranDetail::whereHas('pengajuanIuran', function ($q) use ($month, $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year)
              ->where('status', 'Menunggu Verifikasi');
        })->pluck('household_id')->toArray();

        $data = new Collection();

        foreach ($households as $hh) {
            $due = $paidDues->get($hh->id);
            $isPending = in_array($hh->id, $pendingDetailIds);

            if ($due && $due->status === 'Lunas') {
                $status = 'Sudah Bayar';
                $tglBayar = $due->payment_date ? $due->payment_date->format('d/m/Y') : '-';
                $nominal = $due->paid_amount > 0 ? (float) $due->paid_amount : (float) $due->amount;
                $catatan = $due->notes ?? 'Lunas';
            } elseif ($isPending) {
                $status = 'Menunggu Verifikasi';
                $tglBayar = '-';
                $nominal = 0;
                $catatan = 'Dalam Pengajuan Blok';
            } else {
                $status = 'Belum Bayar';
                $tglBayar = '-';
                $nominal = 0;
                $catatan = 'Belum Ada Pembayaran';
            }

            // Filter by status if specified
            if (!empty($filterStatus)) {
                if ($filterStatus === 'Lunas' && $status !== 'Sudah Bayar') {
                    continue;
                }
                if ($filterStatus === 'Belum Lunas' && $status === 'Sudah Bayar') {
                    continue;
                }
                if ($filterStatus === 'Menunggu Verifikasi' && $status !== 'Menunggu Verifikasi') {
                    continue;
                }
            }

            $data->push((object) [
                'block' => $hh->block->name ?? '-',
                'household_number' => $hh->household_number ?? '-',
                'head_name' => $hh->head_name ?? '-',
                'status' => $status,
                'payment_date' => $tglBayar,
                'nominal' => $nominal,
                'notes' => $catatan,
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Blok',
            'No. Rumah / KK',
            'Nama Kepala Keluarga',
            'Status Pembayaran',
            'Tanggal Bayar',
            'Nominal (Rp)',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->block,
            $row->household_number,
            $row->head_name,
            $row->status,
            $row->payment_date,
            $row->nominal > 0 ? $row->nominal : 0,
            $row->notes,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD9EAD3');

        $totalRows = $this->rowNumber + 1; // 1 for heading

        // Center align No, Blok, Status, Tanggal Bayar
        $sheet->getStyle('A1:A' . $totalRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:B' . $totalRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E1:F' . $totalRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Right align Nominal
        $sheet->getStyle('G2:G' . $totalRows)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G1:G' . $totalRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
