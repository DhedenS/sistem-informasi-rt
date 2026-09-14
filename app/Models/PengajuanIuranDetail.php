<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIuran extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_iuran';

    protected $fillable = [
        'block_id',
        'user_id',
        'bulan',
        'tahun',
        'nominal_per_kk',
        'total_iuran',
        'uang_diterima',
        'bukti',
        'status',
        'catatan',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'nominal_per_kk' => 'decimal:2',
        'total_iuran' => 'decimal:2',
        'uang_diterima' => 'decimal:2',
        'diverifikasi_pada' => 'datetime',
    ];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function details()
    {
        return $this->hasMany(PengajuanIuranDetail::class);
    }

    public function approval()
    {
        return $this->morphOne(Approval::class, 'approvable');
    }
}