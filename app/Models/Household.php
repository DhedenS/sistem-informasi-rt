<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $fillable = ['block_id', 'household_number', 'head_name', 'address', 'phone', 'is_active'];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function dues()
    {
        return $this->hasMany(Due::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
