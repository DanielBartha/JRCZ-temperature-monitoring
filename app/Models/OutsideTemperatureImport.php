<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutsideTemperatureImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'outside_temperature'
    ];
}
