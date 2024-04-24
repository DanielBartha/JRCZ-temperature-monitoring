<?php

namespace App\Http\Controllers;


use App\Imports\RoomTimeImport;
use App\Models\RoomTime;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RoomTimeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'room_info' => 'required|mimes:csv'
        ]);

        Excel::import(new RoomTimeImport, $request->file('room_info'));
        return redirect(route('import.roomTimes'))->with('success', 'Importing file has been properly executed!');
    }
    public function index(){
        return view('import.roomTimes');
    }
    public function update(request $request,RoomTime $roomTime){
       return redirect(route('dashboard',$roomTime));
    }
//    public function tempdata()
//    {
//
//        $data = RoomTime::select('time','co2','temperature')->get();
//        return response()->json($data);
//    }
}
