<?php

namespace App\Imports;

use App\Models\Room;
use App\Models\RoomTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Http\Request;

class RoomTimeImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row): \Illuminate\Database\Eloquent\Model|RoomTime|null
    {
        $rooms = Room::all();
        $roomId=0;
        foreach ($rooms as $room){
            if ($room->room_number === request('set_room')){
                $roomId=$room->id;
                break;
            }
        }
        return new RoomTime([
            'room_id' => $roomId,
            'time' => $this->convertToDateTime($row[0]),
            'co2' => $row[2],
            'temperature' => $row[3]
        ]);
    }
    public function startRow(): int
    {
        return 3;
    }

    private function convertToDateTime($excelDate): string
    {
        return substr($excelDate, 0, 10) . ' ' . substr($excelDate, 11, 8);
    }
}
