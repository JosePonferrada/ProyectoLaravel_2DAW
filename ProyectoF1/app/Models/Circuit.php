<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    /** @use HasFactory<\Database\Factories\CircuitFactory> */
    use HasFactory;

    protected $guarded = [];

    public function races() {
        return $this->hasMany(Race::class);
    }
}
