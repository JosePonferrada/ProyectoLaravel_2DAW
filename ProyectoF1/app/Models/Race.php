<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    /** @use HasFactory<\Database\Factories\RaceFactory> */
    use HasFactory;

    protected $guarded = [];

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'race_driver')->withPivot('position', 'points');
    }

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

}
