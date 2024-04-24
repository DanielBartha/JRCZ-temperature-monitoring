<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateController extends Controller
{
    //this fucntion gets the input from the form in the sidebar and returns the date
    public function getDate(Request $request)
    {
        $date = $request->input('date');
        return $date;
    }
}
