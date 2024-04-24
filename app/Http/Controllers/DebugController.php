<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public  function  index(){
        $rooms = Room::all();
        return view('debug.index',compact('rooms'));
    }
}
