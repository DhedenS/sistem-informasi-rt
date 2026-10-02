<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'type',
        'fund_source_id',
        'transaction_category_id',
        'household_id',
        'due_id',
        'amount',
        'description',
        'proof_file',
        'user_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Transaction $trx) {
            if ($trx->fund_source_id) {
                return;
            }

            if ($trx->type === 'keluar') {
                $name = 'Kas RT';
            } elseif (
                $trx->due_id ||
                TransactionCategory::where('id', $trx->transaction_category_id)->value('name') === 'Iuran Warga'
            ) {
                $name = 'Iuran Warga';
            } else {
                return;
            }

            $trx->fund_source_id = FundSource::firstOrCreate(
                ['name' => $name],
                ['is_active' => true]
            )->id;
        });
    }

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function fundSource()
    {
        return $this->belongsTo(FundSource::class);
    }

    public function category()
    {
        return $this->belongsTo(TransactionCategory::class, 'transaction_category_id');
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function due()
    {
        return $this->belongsTo(Due::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
