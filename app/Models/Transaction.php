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
