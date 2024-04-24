<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OutsideTemperatureController extends Controller
{
    public function create()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://weerlive.nl/api/json-data-10min.php?key=f1de1e8df9&locatie=Middelburg');
        $request = json_decode($response->getBody()->getContents())->liveweer[0];
        $this->store($request);
    }

    public function store($request)
    {
        $outsideTemperature = new \App\Models\OutsideTemperature();
        $request->time = $this->convertTime($request->time);
        $outsideTemperature->time = $request->time;
        $outsideTemperature->temperature = $request->temp;
        $outsideTemperature->image = $request->image;
        $outsideTemperature->save();
    }

    private function convertTime($time)
    {
        $time = substr($time,6,4) . '-' . substr($time,3,2) . '-' . substr($time,0,2) . ' ' . substr($time,11);
        return $time;
    }
}
