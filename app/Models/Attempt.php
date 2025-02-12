<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    public function answers() {
        return $this->hasMany(Option::class);
    }
}
