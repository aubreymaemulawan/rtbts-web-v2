<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Personnel;
use App\Models\Schedule;
use App\Models\PersonnelSchedule;
use DB;
date_default_timezone_set('Asia/Manila');

class BusController extends Controller
{
    public function list(Request $request){
        return json_encode(Bus::with(['company'])->get());
    }

    public function items(Request $request){
        return json_encode(Bus::with(['company'])->find($request->id));
    }

    public function create(Request $request){
        // Validation Rules
        $request->validate([
            'company_id' => 'required',
            'bus_no' => 'required|unique:bus',
            'bus_type' => 'required',
            'plate_no' => 'required|unique:bus',
            'chassis_no' => 'required|unique:bus',
            'engine_no' => 'required|unique:bus',
            'color' => 'required|unique:bus',
        ],[
            'bus_type.required' => 'The bus type selection is required.',
            'bus_no.required' => 'The bus number field is required.',
            'bus_no.unique' => 'The bus number has already been taken.',
            'plate_no.required' => 'The plate number field is required.',
            'plate_no.unique' => 'The plate number has already been taken.',
            'chassis_no.required' => 'The chassis number field is required.',
            'chassis_no.unique' => 'The chassis number has already been taken.',
            'engine_no.required' => 'The engine number field is required.',
            'engine_no.unique' => 'The engine number has already been taken.',
        ]);

        // Create Data in DB (Bus Table)
        $data = new Bus();
        $data->company_id = $request->company_id;
        $data->bus_no = $request->bus_no;
        $data->bus_type = $request->bus_type;
        $data->plate_no = $request->plate_no;
        $data->chassis_no = $request->chassis_no;
        $data->engine_no = $request->engine_no;
        $data->color = $request->color;
        $data->status = 1;

        // Save to DB (Bus Table)
        $data->save();

        // Return
        return json_encode( 
            ['success'=>true]
        );
    } 

    public function update(Request $request){
        // Validation Rules
        $request->validate([
            'company_id' => 'required',
            'bus_type' => 'required',
            'bus_no' => ['required', Rule::unique('bus','bus_no')->ignore($request->id)],
            'plate_no' => ['required', Rule::unique('bus','plate_no')->ignore($request->id)],
            'chassis_no' => ['required', Rule::unique('bus','chassis_no')->ignore($request->id)],
            'engine_no' => ['required', Rule::unique('bus','engine_no')->ignore($request->id)],
            'color' => ['required', Rule::unique('bus','color')->ignore($request->id)],
            'status' => 'required',
        ],[
            'bus_no.required' => 'The bus number field is required.',
            'bus_no.unique' => 'The bus number has already been taken.',
            'plate_no.required' => 'The plate number field is required.',
            'plate_no.unique' => 'The plate number has already been taken.',
            'chassis_no.required' => 'The chassis number field is required.',
            'chassis_no.unique' => 'The chassis number has already been taken.',
            'engine_no.required' => 'The engine number field is required.',
            'engine_no.unique' => 'The engine number has already been taken.',
        ]);

        $count = 0;
        $find_persched = PersonnelSchedule::where('bus_id',$request->id)->get();
        foreach($find_persched as $val){
            if($val->status == 1){
                $count += 1;
            }
        }
        if($request->status == 2 && $count != 0){ 
            // There is an active assigned-schedule using that bus id
            return response()->json(1);
        }else{        

            // Update Data in DB (Bus Table)
            $data = Bus::find($request->id);
            $data->company_id = $request->company_id;
            $data->bus_type = $request->bus_type;
            $data->bus_no = $request->bus_no;
            $data->plate_no = $request->plate_no;
            $data->chassis_no = $request->chassis_no;
            $data->engine_no = $request->engine_no;
            $data->color = $request->color;
            $data->status = $request->status;

            // Save to DB (Bus Table)
            $data->save();

            // If status is active, update fk in personnel schedule tbl
            if($request->status == 1){
                // Check conductor, dispatcher, operator & schedule of Bus if Active
                $bus_val = PersonnelSchedule::where('bus_id', $request->id)->get();
                foreach($bus_val as $bs){
                    $bus_cn_status = Personnel::where('id', $bs->conductor_id)->value('status');
                    $bus_dp_status = Personnel::where('id', $bs->dispatcher_id)->value('status');
                    $bus_op_status = Personnel::where('id', $bs->operator_id)->value('status');
                    $bus_sc_status = Schedule::where('id', $bs->schedule_id)->value('status');
                    if($bus_cn_status == 1 && $bus_dp_status == 1 && $bus_op_status == 1 && $bus_sc_status == 1){
                        DB::table('personnel_schedule')->where([
                            ['conductor_id', '=', $bs->conductor_id],
                            ['dispatcher_id', '=', $bs->dispatcher_id],
                            ['operator_id', '=', $bs->operator_id],
                            ['schedule_id', '=', $bs->schedule_id],
                            ['status', '=', 4]
                        ])->update(['status' => 1]);
                    }
                }
            }
            
            // If status is not active, update fk in personnel schedule tbl
            else if($request->status == 2){
                // Set status in personnel_schedule tbl
                DB::table('personnel_schedule')->where([['bus_id', '=', $request->id],['status', '=', 1]])->update(['status' => 4]);
            }

            // Return 
            return json_encode(
                ['success'=>true]
            );
        }
    }
    
    public function delete(Request $request){
        $count1 = 0;
        $data = Bus::find($request->id);
        $find_persched = PersonnelSchedule::where('bus_id',$request->id)->get();
        foreach($find_persched as $val){
            $count1++;
        }
        if($count1 != 0){ // There is an assigned-schedule using that bus id
            return response()->json(1);
        }else{
            $data->delete();
            return json_encode( 
                ['success'=>true]
            );
        }
    }
    
}
