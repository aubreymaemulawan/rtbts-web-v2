<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Personnel;
use App\Models\PersonnelSchedule;
use DB;
date_default_timezone_set('Asia/Manila');

class ScheduleController extends Controller 
{
    public function list(Request $request){
        return json_encode(Schedule::with(['company','route'])->get());
    }

    public function items(Request $request){
        return json_encode(Schedule::with(['company','route'])->find($request->id));
    }

    public function create(Request $request){
        // Validation Rules
        $request->validate([
            'company_id' => 'required',
            'route_id' => 'required|unique:schedule' ,
            'first_trip' => 'required' ,
            'last_trip' => 'required' ,
            'interval_mins' => 'required' ,
        ],[
            'route_id.required' => 'The route selection is required.',
            'route_id.unique' => 'The route has already been used.',
            'interval_mins.required' => 'The interval minutes field is required.',
        ]);

        // Create Data in DB (Schedule Table)
        $data = new Schedule();
        $data->company_id = $request->company_id;
        $data->route_id = $request->route_id;
        $data->first_trip = $request->first_trip;
        $data->last_trip = $request->last_trip;
        $data->interval_mins = $request->interval_mins;
        $data->status = 1;

        // Save to DB (Schedule Table)
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
            'route_id' => ['required', Rule::unique('schedule','route_id')->ignore($request->id)],
            'first_trip' => 'required' ,
            'last_trip' => 'required' ,
            'interval_mins' => 'required' ,
            'status' => 'required',
        ],[
            'route_id.required' => 'The route selection is required.',
            'route_id.unique' => 'The route has already been used.',
            'interval_mins.required' => 'The interval minutes field is required.',
        ]);

        $count = 0;
        $find_persched = PersonnelSchedule::where('schedule_id',$request->id)->get();
        foreach($find_persched as $val){
            if($val->status == 1){
                $count += 1;
            }
        }
        if($request->status == 2 && $count != 0){ 
            // There is an active assigned-schedule using that bus id
            return response()->json(1);
        }else{   

            // Update Data in DB (Schedule Table)
            $data = Schedule::find($request->id);
            $data->company_id = $request->company_id;
            $data->route_id = $request->route_id;
            $data->first_trip = $request->first_trip;
            $data->last_trip = $request->last_trip;
            $data->interval_mins = $request->interval_mins;
            $data->status = $request->status;

            // Save to DB (Schedule Table)
            $data->save();

            // If status is active, update fk in personnel schedule tbl
            if($request->status == 1){
                // Check conductor, dispatcher, operator & bus of Schedule if Active
                $schedule_val = PersonnelSchedule::where('schedule_id', $request->id)->get();
                foreach($schedule_val as $sched){
                    $schedule_cn_status = Personnel::where('id', $sched->conductor_id)->value('status');
                    $schedule_dp_status = Personnel::where('id', $sched->dispatcher_id)->value('status');
                    $schedule_op_status = Personnel::where('id', $sched->operator_id)->value('status');
                    $schedule_bs_status = Bus::where('id', $sched->bus_id)->value('status');
                    if($schedule_cn_status == 1 && $schedule_dp_status == 1 && $schedule_op_status == 1 && $schedule_bs_status == 1){
                        DB::table('personnel_schedule')->where([
                            ['conductor_id', '=', $sched->conductor_id],
                            ['dispatcher_id', '=', $sched->dispatcher_id],
                            ['operator_id', '=', $sched->operator_id],
                            ['bus_id', '=', $sched->bus_id],
                            ['status', '=', 4]
                        ])->update(['status' => 1]);
                    }
                }
            }
            
            // If status is not active, update fk in personnel schedule tbl
            else if($request->status == 2){
                // Set status in personnel_schedule tbl
                DB::table('personnel_schedule')->where([['schedule_id', '=', $request->id],['status', '=', 1]])->update(['status' => 4]);
            }

            // Return
            return json_encode(
                ['success'=>true]
            );
        }
    }

    public function delete(Request $request){
        $count1 = 0;
        $data = Schedule::find($request->id);
        $find_persched = PersonnelSchedule::where('schedule_id',$request->id)->get();
        foreach($find_persched as $val){
            $count1 ++;
        }
        if($count1 != 0){ // There is an active assigned-schedule using that schedule id
            return response()->json(1);
        }else{
            $data->delete();
            return json_encode( 
                ['success'=>true]
            );
        }
        
    }
 
}
