<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IuranRate extends Model
{
    protected $fillable = ['year', 'month', 'amount'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Ambil nominal iuran yang berlaku untuk bulan & tahun tertentu.
     */
    public static function getRateFor(int $month, int $year): float
    {
        $rate = self::where(function ($q) use ($month, $year) {
                $q->where('year', '<', $year)
                  ->orWhere(function ($q2) use ($month, $year) {
                      $q2->where('year', $year)->where('month', '<=', $month);
                  });
            })
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->first();

        return $rate ? (float) $rate->amount : 30000; // fallback default
    }
}
