<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
        'isi_ringkas',
        'file_surat',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];
}
