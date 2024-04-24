<?php

namespace App\Http\Controllers;
use App\Models\OutsideTemperatureImport;
use App\Models\Room;
use App\Models\RoomTime;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roomsToSwitch = Room::all();
        return view('dashboard', compact('roomsToSwitch'));
    }

    public function getRoomsAndTemperatures()
    {
        $data = [];
        $rooms = Room::all();
        foreach ($rooms as $room) {
            $roomTimes = [];
            foreach ($room->roomTime as $roomTime) {
                $seperatedTime = explode(' ', $roomTime->time);
                array_push($roomTimes, [
                    'dateAndTime' => [
                        'date' => $seperatedTime[0],
                        'time' => $seperatedTime[1]
                    ],
                    'co2' => $roomTime->co2,
                    'temperature' => $roomTime->temperature
                ]);
            }
            $roomData = [
                'room_name' => $room->room_number,
                'roomTimes' => $roomTimes
            ];
            array_push($data, $roomData);
        }
        $outsideTemperatureImport = OutsideTemperatureImport::all()->sort();
        $outsideTemperatures = [];
        foreach ($outsideTemperatureImport as $outsideTemperature) {
            $seperatedTime = explode(' ', $outsideTemperature->time);
            array_push($outsideTemperatures, [
                'dateAndTime' => [
                    'date' => $seperatedTime[0],
                    'time' => $seperatedTime[1]
                ],
                'outside_temperature' => $outsideTemperature->outside_temperature
            ]);
        }
        array_push($data, $outsideTemperatures);
        return $data;
    }
}
