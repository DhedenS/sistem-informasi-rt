<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Block extends Model
{
   public function deposits()
{
    return $this->hasMany(BlockDeposit::class);
}
}

