<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundSource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
