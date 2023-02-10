<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Location;
date_default_timezone_set('Asia/Manila');

class LocationController extends Controller
{
    public function list(Request $request){
        return json_encode(Location::all());
    }
    
    public function items(Request $request){
        return json_encode(Location::find($request->id));
    }

    public function create(Request $request){
        $request->validate([ 
            'place' => 'required|unique:location',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        $data = new Location();
        $data->place = $request->place;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        $request->validate([ 
            'place' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        $data = Location::find($request->id);
        $data->place = $request->place;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function delete(Request $request){
        $data = Location::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
