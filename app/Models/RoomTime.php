<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTime extends Model
{
    protected $fillable = [
        'room_id',
        'time',
        'co2',
        'temperature'
    ];
    use HasFactory;

    function room(){
       return $this->belongsTo(Room::class);
    }
}
