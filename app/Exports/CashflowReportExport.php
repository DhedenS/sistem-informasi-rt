<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashflowReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    private $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query(): Builder
    {
        $query = Transaction::with(['fundSource', 'category', 'household.block', 'user']);

        if (! empty($this->filters['type'])) {
            $query->where('type', $this->filters['type']);
        }

        if (! empty($this->filters['category_id'])) {
            $query->where('transaction_category_id', $this->filters['category_id']);
        }

        if (! empty($this->filters['fund_source_id'])) {
            $query->where('fund_source_id', $this->filters['fund_source_id']);
        }

        if (! empty($this->filters['block_id'])) {
            $query->whereHas('household', function ($q) {
                $q->where('block_id', $this->filters['block_id']);
            });
        }

        if (! empty($this->filters['start_date']) && ! empty($this->filters['end_date'])) {
            $query->whereBetween('transaction_date', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        return $query->orderBy('transaction_date', 'asc');
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jenis',
            'Kategori',
            'Sumber Dana',
            'Blok / KK',
            'Jumlah (Rp)',
            'Keterangan',
            'Pencatat',
        ];
    }

    public function map($transaction): array
    {
        $this->rowNumber++;
        $householdInfo = $transaction->household ? ($transaction->household->block->name ?? '').' - '.$transaction->household->head_name : '-';

        return [
            $this->rowNumber,
            $transaction->transaction_date->format('d/m/Y'),
            ucfirst($transaction->type),
            $transaction->category->name ?? '-',
            $transaction->fundSource->name ?? '-',
            $householdInfo,
            $transaction->amount,
            $transaction->description ?? '-',
            $transaction->user->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
