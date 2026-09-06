<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['name', 'code', 'is_active'];

    public function households()
    {
        return $this->hasMany(Household::class);
    }
}
