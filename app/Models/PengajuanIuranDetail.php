<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIuranDetail extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_iuran_detail';

    protected $fillable = [
        'pengajuan_iuran_id',
        'household_id',
    ];

    // Pengajuan iuran
    public function pengajuanIuran()
    {
        return $this->belongsTo(PengajuanIuran::class);
    }

    // KK yang dipilih
    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}