<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $roomNumbers = [210, 211, 212, 213, 214];

        foreach ($roomNumbers as $roomNumber) {
            Room::create([
                'room_number' => $roomNumber
            ]);
        }

    }
}
