<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    protected $fillable = [
        'approval_id',
        'user_id',
        'action',
        'from_status',
        'to_status',
        'notes',
        'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public function approval()
    {
        return $this->belongsTo(Approval::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}