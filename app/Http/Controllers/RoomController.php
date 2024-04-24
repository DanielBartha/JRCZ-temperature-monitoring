<?php

namespace App\Http\Controllers;


use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index() {
        $roomsToSwitch = Room::all();

        return view('layouts.navbars.sidebar', ['roomsToSwitch' => $roomsToSwitch] );
    }

    public function show($room) {
            return view('RC210_dashboard', compact('room'));
    }
}

