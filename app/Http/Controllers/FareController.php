<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Fare;
date_default_timezone_set('Asia/Manila');

class FareController extends Controller
{
    public function list(Request $request){
        return json_encode(Fare::with(['route'])->get());
    }

    public function items(Request $request){
        return json_encode(Fare::with(['route'])->find($request->id));
    }

    public function create(Request $request){
        // Check if route still available for selected bus type
        $route_id = Fare::where('bus_type',$request->bus_type)->get();
        foreach($route_id as $rd){
            if($rd->route_id == $request->route_id){
                return response()->json(1);
            }
        }

        // Validation Rules
        $request->validate([
            'route_id' => 'required',
            'bus_type' => 'required',
            'price' => 'required',
        ],[
            'route_id.required' => 'The route selection is required.',
            'bus_type.required' => 'The bus type selection is required.',
        ]);
        
        // Create Data in DB (Fare Table)
        $data = new Fare();
        $data->route_id = $request->route_id;
        $data->bus_type = $request->bus_type;
        $data->price = $request->price;
        $data->save();

        // Return
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        // Check if route still available for selected bus type
        $route_id = Fare::where('bus_type',$request->bus_type)->get();
        foreach($route_id as $rd){
            if($rd->route_id == $request->route_id){
                if($rd->id != $request->id){
                    return response()->json(1);
                }
            }
        }

        // Validation Rules
        $request->validate([
            'route_id' => 'required',
            'bus_type' => 'required',
            'price' => 'required',
        ]);

        // Update Data in DB (Fare Table)
        $data = Fare::find($request->id);
        $data->route_id = $request->route_id;
        $data->bus_type = $request->bus_type;
        $data->price = $request->price;
        $data->save();

        // Return
        return json_encode(
            ['success'=>true]
        );
    }
    
    public function delete(Request $request){
        $data = Fare::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
