<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Trip;
date_default_timezone_set('Asia/Manila');

class TripController extends Controller
{
    public function list(Request $request){
        return json_encode(Trip::with(['schedule'])->get());
    }

    public function items(Request $request){
        return json_encode(Trip::with(['schedule'])->find($request->id));
    }

    public function create(Request $request){
        $request->validate([ 
            'schedule_id' => 'required',
            'trip_no' => 'required',
            'trip_duration' => 'required',
            'arrived' => 'required',
        ]);
        $data = new Trip();
        $data->schedule_id = $request->schedule_id;
        $data->trip_no = $request->trip_no;
        $data->trip_duration = $request->trip_duration;
        $data->arrived = $request->arrived;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        $request->validate([ 
            'schedule_id' => 'required',
            'trip_no' => 'required',
            'trip_duration' => 'required',
            'arrived' => 'required',
        ]);
        $data = Trip::find($request->id);
        $data->schedule_id = $request->schedule_id;
        $data->trip_no = $request->trip_no;
        $data->trip_duration = $request->trip_duration;
        $data->arrived = $request->arrived;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }
    
    public function delete(Request $request){
        $data = Trip::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
