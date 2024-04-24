<?php

namespace App\Http\Controllers;

use App\Imports\OutsideTemperatureImportImport;
use App\Models\OutsideTemperatureImport;
use App\Models\RoomTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OutsideTemperatureImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'room_info' => 'required|mimes:csv'
        ]);

        Excel::import(new OutsideTemperatureImportImport(), $request->file('room_info'));
        return redirect(route('import.outsideTemperatureImport'))->with('success', 'Importing file has been properly executed!');
    }
    public function index(){
        return view('import.outsideTemperatureImport');
    }
    public function update(request $request,OutsideTemperatureImport $outsideTemperatureImport){
        return redirect(route('dashboard',$outsideTemperatureImport));
    }
}
