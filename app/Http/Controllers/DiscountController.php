<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Discount;
date_default_timezone_set('Asia/Manila');

class DiscountController extends Controller
{
    public function list(Request $request){
        return json_encode(Discount::all());
    }

    public function items(Request $request){
        return json_encode(Discount::find($request->id));
    }    

    public function create(Request $request){
        $data = new Discount();
        $data->passenger_type = $request->passenger_type;
        $data->discount = $request->discount;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        $data = Discount::find($request->id);
        $data->passenger_type = $request->passenger_type;
        $data->discount = $request->discount;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }
    
    public function delete(Request $request){
        $data = Discount::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
