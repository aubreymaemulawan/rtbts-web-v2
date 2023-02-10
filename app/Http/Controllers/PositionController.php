<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Position;
date_default_timezone_set('Asia/Manila');

class PositionController extends Controller
{
    public function list(Request $request){
        return json_encode(Position::with(['bus'])->get());
    }

    public function items(Request $request){
        return json_encode(Position::with(['bus'])->find($request->id));
    }

    public function create(Request $request){
        $request->validate([
            'bus_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'speed' => 'required',
        ]);
        $data = new Position();
        $data->bus_id = $request->bus_id;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->speed = $request->speed;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        $request->validate([
            'bus_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'speed' => 'required',
        ]);
        $data = Position::find($request->id);
        $data->bus_id = $request->bus_id;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;
        $data->speed = $request->speed;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }
    
    public function delete(Request $request){
        $data = Position::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
