<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockDeposit extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REVISION = 'revision';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'block_id',
        'user_id',
        'month',
        'year',
        'expected_amount',
        'submitted_amount',
        'difference',
        'status',
        'notes',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'expected_amount' => 'decimal:2',
        'submitted_amount' => 'decimal:2',
        'difference' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * True jika uang yang disetor sama dengan
     * pembayaran warga yang tercatat.
     */
    public function getIsMatchedAttribute(): bool
    {
        return bccomp(
            (string) $this->expected_amount,
            (string) $this->submitted_amount,
            2
        ) === 0;
    }
}