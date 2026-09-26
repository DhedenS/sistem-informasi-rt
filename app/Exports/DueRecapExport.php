<?php

namespace App\Exports;

use App\Models\Due;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DueRecapExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filters;
    private $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query(): Builder
    {
        $query = Due::with('household')
            ->whereHas('household', fn ($q) => $q->where('block_id', $this->filters['block_id']));

        if (!empty($this->filters['month'])) {
            $query->where('month', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->where('year', $this->filters['year']);
        }

        if (!empty($this->filters['household_id'])) {
            $query->where('household_id', $this->filters['household_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('household_id');
    }

    public function headings(): array
    {
        return ['No', 'No. KK', 'Kepala Keluarga', 'Periode', 'Nominal (Rp)', 'Status', 'Tanggal Bayar'];
    }

    public function map($due): array
    {
        $this->rowNumber++;

        $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        return [
            $this->rowNumber,
            $due->household->household_number,
            $due->household->head_name,
            ($months[$due->month] ?? '') . ' ' . $due->year,
            $due->amount,
            $due->status,
            $due->payment_date?->format('d/m/Y') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
