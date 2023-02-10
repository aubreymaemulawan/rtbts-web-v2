<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Status;
date_default_timezone_set('Asia/Manila');

class StatusController extends Controller
{
    public function list(Request $request){
        return json_encode(Status::with(['trip'])->get());
    }

    public function items(Request $request){
        return json_encode(Status::with(['trip'])->where('trip_id',$request->trip_id)->orderBy('created_at','desc')->get());
    }

    public function create(Request $request){
        $request->validate([ 
            'trip_id' => 'required',
            'status' => 'required',
        ]);
        $data = new Status();
        $data->trip_id = $request->trip_id;
        $data->status = $request->status;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        $request->validate([ 
            'trip_id' => 'required',
            'status' => 'required',
        ]);
        $data = Status::find($request->id);
        $data->trip_id = $request->trip_id;
        $data->status = $request->status;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }
    
    public function delete(Request $request){
        $data = Status::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
