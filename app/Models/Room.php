<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'Room number',
    ];

    public function roomTime()
    {
        return $this->hasMany(RoomTime::class);
    }

    use HasFactory;
}
