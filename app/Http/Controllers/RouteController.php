<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Schedule;
use App\Models\PersonnelSchedule;
use DB;
date_default_timezone_set('Asia/Manila');

class RouteController extends Controller
{
    public function list(Request $request){
        return json_encode(Route::with(['company'])->get());
    }

    public function items(Request $request){
        return json_encode(Route::with(['company'])->find($request->id));
    }

    public function create(Request $request){
        $cnt = null;

        // Validation Rules
        $request->validate([ 
            'from_to_location' => ['required', Rule::unique('route')->where(function ($query) use($request) {
                                                return $query->where('from_to_location', $request->from_to_location)
                                                ->where('company_id', $request->company_id);}),],
            'origin' => 'required|not_in:'.$request->destination,
            'destination' => 'required|not_in:'.$request->origin,
            'company_id' => 'required',
            'orig_address' => 'required',
            'orig_latitude' => 'required',
            'orig_longitude' => 'required',
            'dest_address' => 'required',
            'dest_latitude' => 'required',
            'dest_longitude' => 'required',
        ],[
            'from_to_location.unique' => 'The route '.$request->origin.' - '.$request->destination.' has already been registered.',
            'orig_address.required' => 'The origin address field is required.',
            'orig_latitude.required' => 'The latitude field is required.',
            'orig_longitude.required' => 'The longitude field is required.',
            'dest_address.required' => 'The destination address field is required.',
            'dest_latitude.required' => 'The latitude field is required.',
            'dest_longitude.required' => 'The longitude field is required.',
        ]);

        // // Convert string to vice versa
        // $str1 = $request->from_to_location;
        // $orig_dest1 = explode(" - ", $str1);
        // $a1 = $orig_dest1[0];
        // $b1 = $orig_dest1[1];
        // $vv1 = $b1." - ".$a1;

        // // Convert all route string to vice versa
        // $routes = Route::all();
        // foreach($routes as $rt){
        //     if($rt->company_id == $request->company_id){
        //         $str = $rt->from_to_location;
        //         $orig_dest = explode(" - ", $str);
        //         $a = $orig_dest[0];
        //         $b = $orig_dest[1];
        //         $vv = $b." - ".$a;
        //         if($vv == $vv1 || $vv == $request->from_to_location){
        //             $cnt += 1;
        //         }
        //     }
        // }

        // // If route value is already registered, return error
        // if($cnt > 0){
        //     return response()->json(1);
        // }    

        // Else save to DB
        // else{

            // Create Data in DB (Route Table)
            $data = new Route();        
            $data->from_to_location = $request->from_to_location;
            $data->company_id = $request->company_id;
            $data->orig_address = $request->orig_address;
            $data->orig_latitude = $request->orig_latitude;
            $data->orig_longitude = $request->orig_longitude;
            $data->dest_address = $request->dest_address;
            $data->dest_latitude = $request->dest_latitude;
            $data->dest_longitude = $request->dest_longitude;
            $data->save();

            // Return
            return json_encode(
                ['success'=>true]
            );
        // }
        
    }

    public function update(Request $request){
        // Validation Rules
        $request->validate([ 
            'from_to_location' => ['required', Rule::unique('route')->where(function ($query) use($request) {
                                                return $query->where('from_to_location', $request->from_to_location)
                                                ->where('company_id', $request->company_id);})->ignore($request->id),],
            'origin' => 'required|not_in:'.$request->destination,
            'destination' => 'required|not_in:'.$request->origin,
            'company_id' => 'required',
            'orig_address' => 'required',
            'orig_latitude' => 'required',
            'orig_longitude' => 'required',
            'dest_address' => 'required',
            'dest_latitude' => 'required',
            'dest_longitude' => 'required',
        ],[
            'from_to_location.unique' => 'The route '.$request->origin.' - '.$request->destination.' has already been registered.',
            'orig_address.required' => 'The origin address field is required.',
            'orig_latitude.required' => 'The latitude field is required.',
            'orig_longitude.required' => 'The longitude field is required.',
            'dest_address.required' => 'The destination address field is required.',
            'dest_latitude.required' => 'The latitude field is required.',
            'dest_longitude.required' => 'The longitude field is required.',
        ]);
      
        // Update Data in DB (Bus Table)
        $data = Route::find($request->id);
        $data->from_to_location = $request->from_to_location;
        $data->company_id = $request->company_id;
        $data->orig_address = $request->orig_address;
        $data->orig_latitude = $request->orig_latitude;
        $data->orig_longitude = $request->orig_longitude;
        $data->dest_address = $request->dest_address;
        $data->dest_latitude = $request->dest_latitude;
        $data->dest_longitude = $request->dest_longitude;

        // Save to DB (Bus Table)
        $data->save();

        // Return 
        return json_encode(
            ['success'=>true]
        );
        
    }

    public function delete(Request $request){
        $count1 = 0;
        $data = Route::find($request->id);
        $find_id = Schedule::where('route_id',$request->id)->value('id');
        $find_sched = Schedule::where('route_id',$request->id)->get();
        foreach($find_sched as $val1){
            $count1++;
        }
        if($count1 != 0){ // There is a schedule using that route id
            return response()->json(1);
        }
        else{
            $data->delete();
            return json_encode(
                ['success'=>true]
            );
        }
        
    }

    public function check(Request $request){
        $cnt = 0;
        $persched = PersonnelSchedule::where('id', $request->persched_id)->get();
        foreach($persched as $ps){
            $trip = Trip::where('personnel_schedule_id', $ps->id)->get();
            foreach($trip as $tr){
                $cnt++;
            }
        }
        if($cnt==0){
            return response()->json(1);
        }else{
            return response()->json(0);
        }
        
    }
}
