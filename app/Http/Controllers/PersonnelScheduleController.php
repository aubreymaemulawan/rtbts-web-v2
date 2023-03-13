<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PersonnelSchedule;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Account;
use App\Models\Trip;
use App\Models\Personnel;
date_default_timezone_set('Asia/Manila'); 

class PersonnelScheduleController extends Controller
{
    
    public function list(Request $request){
        return json_encode(PersonnelSchedule::with(['schedule','personnel','bus'])->get());
    }

    public function items(Request $request){
        return json_encode(PersonnelSchedule::with(['schedule','personnel','bus'])->find($request->id));
    }

    public function create(Request $request){
        // Check if still available for selected date
        // $val = PersonnelSchedule::where([['status','!=',2],['date',$request->date]])->get();
        // $cnt_bus = 0;
        // $cnt_conductor = 0;
        // $cnt_dispatcher = 0;
        // $cnt_operator = 0;
        // // Return error
        // foreach($val as $vl){
        //     if($vl->bus_id == $request->bus_id){
        //         $cnt_bus++; 
        //     }
        //     else if($vl->conductor_id == $request->conductor_id){
        //         $cnt_conductor++; 
        //     }
        //     else if($vl->operator_id == $request->operator_id){
        //         $cnt_operator++; 
        //     }
        // }

        // if($cnt_bus != 0){
        //     return response()->json(1);
        // }
        // if($cnt_conductor != 0){
        //     return response()->json(2);
        // }
        // if($cnt_operator != 0){
        //     return response()->json(4);
        // }

        // Validation Rules
        $request->validate([
            'schedule_id' => 'required',
            'conductor_id' => 'required',
            'operator_id' => 'required',
            'bus_id' => 'required',
            'date' => ['required', 'after_or_equal:' . now()->format('Y-m-d')],
            'max_trips' => 'required', 
        ],[
            'date.required' => 'The schedule date selection is required.',
            'schedule_id.required' => 'The schedule route selection is required.',
            'conductor_id.required' => 'The conductor selection is required.',
            'operator_id.required' => 'The operator selection is required.',
            'bus_id.required' => 'The bus selection is required.',
            'max_trips.required' => 'The maximum trips field is required.',
        ]);

        // Create Data in DB (Personnel Schedule Table)
        $data = new PersonnelSchedule();
        $data->schedule_id = $request->schedule_id;
        $data->conductor_id = $request->conductor_id;
        $data->dispatcher_id = $request->dispatcher_id;
        $data->operator_id = $request->operator_id;
        $data->bus_id = $request->bus_id;
        $data->date = $request->date;
        $data->max_trips = $request->max_trips;
        $data->status = 1;

        // Save to DB (Personnel Schedule Table)
        $data->save();

        // Return
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        // Check if still available for selected date
        $val = PersonnelSchedule::where('date',$request->date)->get();

        // Return error
        foreach($val as $vl){
            if($vl->id != $request->id){
                if($vl->bus_id == $request->bus_id){
                    return response()->json(1); 
                }
                if($vl->conductor_id == $request->conductor_id){
                    return response()->json(2);
                }
                // if($vl->dispatcher_id == $request->dispatcher_id){
                //     return response()->json(3);
                // }
                if($vl->operator_id == $request->operator_id){
                    return response()->json(4);
                }
            }
        }

        // Validation Rules
        $request->validate([
            'schedule_id' => 'required',
            'conductor_id' => 'required',
            'dispatcher_id' => 'required',
            'operator_id' => 'required',
            'bus_id' => 'required',
            'date' => ['required', 'after_or_equal:' . now()->format('Y-m-d')],
            'max_trips' => 'required',
            'status' => 'required',  
        ],[
            'date.required' => 'The schedule date selection is required.',
            'schedule_id.required' => 'The schedule route selection is required.',
            'conductor_id.required' => 'The conductor selection is required.',
            'dispatcher_id.required' => 'The dispatcher selection is required.',
            'operator_id.required' => 'The operator selection is required.',
            'bus_id.required' => 'The bus selection is required.',
            'max_trips.required' => 'The maximum trips field is required.',
        ]);

        // Update Data in DB (Personnel Schedule Table)
        $data = PersonnelSchedule::find($request->id);
        $data->schedule_id = $request->schedule_id;
        $data->conductor_id = $request->conductor_id;
        $data->dispatcher_id = $request->dispatcher_id;
        $data->operator_id = $request->operator_id;
        $data->bus_id = $request->bus_id;
        $data->date = $request->date;
        $data->max_trips = $request->max_trips;
        $data->status = $request->status;

        // Save to DB (Personnel Schedule Table)
        $data->save();

        // Return
        return json_encode(
            ['success'=>true]
        );
    }

    public function delete(Request $request){
        $data = PersonnelSchedule::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }

    public function find(Request $request){
        $con = PersonnelSchedule::where('id',$request->id)->value('conductor_id');
        $dis = PersonnelSchedule::where('id',$request->id)->value('dispatcher_id');
        
        $ope = PersonnelSchedule::where('id',$request->id)->value('operator_id');
        $conductor_name = Personnel::where('id',$con)->value('name');
        $conductor_status = Personnel::where('id',$con)->value('status');
        $conductor_acc_email = Account::where('personnel_id',$con)->value('email');
        $conductor_acc_pass = Account::where('personnel_id',$con)->value('password');
        $conductor_picture = Personnel::where('id',$con)->value('profile_path');
        if($conductor_picture != null){
            $con_str = $conductor_picture;
            $con_str = ltrim($con_str, 'public/');
            $con_pic = "../storage/".$con_str;
        }else{
            $con_pic = "";
        }
        
        $dispatcher_name = Personnel::where('id',$dis)->value('name');
        $dispatcher_status = Personnel::where('id',$dis)->value('status');
        $dispatcher_acc_email = Account::where('personnel_id',$dis)->value('email');
        $dispatcher_acc_pass = Account::where('personnel_id',$dis)->value('password');
        $dispatcher_picture = Personnel::where('id',$dis)->value('profile_path');
        if($dispatcher_picture != null){
            $dis_str = $dispatcher_picture;
            $dis_str = ltrim($dis_str, 'public/');
            $dis_pic = "../storage/".$dis_str;
        }else{
            $dis_pic = "";
        }

        $operator_name = Personnel::where('id',$ope)->value('name');
        $operator_status = Personnel::where('id',$ope)->value('status');
        $operator_acc_email = Account::where('personnel_id',$ope)->value('email');
        $operator_acc_pass = Account::where('personnel_id',$ope)->value('password');
        $operator_picture = Personnel::where('id',$ope)->value('profile_path');
        if($operator_picture != null){
            $ope_str = $operator_picture;
            $ope_str = ltrim($ope_str, 'public/');
            $ope_pic = "../storage/".$ope_str;
        }else{
            $ope_pic = "";
        }

        $trip = Trip::where([['personnel_schedule_id',$request->id],['arrived',0]])->get();
        $trip_cnt = count($trip);

        // $test = '<script>'.$dispatcher_name.'</script>';
        // echo $test;
        return response()->json([
            $conductor_name, $conductor_status, $conductor_acc_email, $conductor_acc_pass, $con_pic,
            $dispatcher_name, $dispatcher_status, $dispatcher_acc_email, $dispatcher_acc_pass, $dis_pic,
            $operator_name, $operator_status, $operator_acc_email, $operator_acc_pass, $ope_pic, $trip_cnt
        ]);
    }

    public function find1(Request $request){
        $bus_id = "";
        $status = ""; 
        $from_to_location = "";
        $bus = PersonnelSchedule::where('id',$request->id)->value('bus_id');
        $sched = PersonnelSchedule::where('id',$request->id)->value('schedule_id');
        $stat = PersonnelSchedule::where('id',$request->id)->value('status');
        $max_trips = PersonnelSchedule::where('id',$request->id)->value('max_trips');
        $route_id = Schedule::where('id',$sched)->value('route_id');
        $sched_status = Schedule::where('id',$sched)->value('status');
        $location = Route::where('id',$route_id)->value('from_to_location');
        $bus_no = Bus::where('id',$bus)->value('bus_no');
        $bus_type = Bus::where('id',$bus)->value('bus_type');
        $bus_status = Bus::where('id',$bus)->value('status');

        if($bus_status == 1){
            if($bus_type == 1){
                $bus_id = $bus_no." - Airconditioned";
            }else if($bus_type == 2){
                $bus_id = $bus_no." - Non Airconditioned";
            }
        }else if($bus_status == 2){
            if($bus_type == 1){
                $bus_id = $bus_no." - Airconditioned (NOT ACTIVE)";
            }else if($bus_type == 2){
                $bus_id = $bus_no." - Non Airconditioned (NOT ACTIVE)";
            }
        }

        if($sched_status == 1){
            $from_to_location = $location;
        }else if($sched_status == 2){
            $from_to_location = $location." (NOT ACTIVE)";
        }

        if($stat == 1){
            $status = "Active";
        }else if($stat == 2){
            $status = "Cancelled";
        }else if($stat == 3){
            $status = "Done";
        }else if($stat == 4){
            $status = "Need Update (MISSING VALUES)";
        }
        
        return response()->json([
            $bus_id, $from_to_location, $max_trips, $status
        ]);
    }

    public function check_bus(Request $request){
        $bus = array();
        // Check if still available for selected date
        if($request->type){
            if($request->type == 'update'){
                $val = PersonnelSchedule::where([['id','==',$request->ps_id],['status','!=',2],['date',$request->date]])->get();
            }
        }else{
            $val = PersonnelSchedule::where([['status','!=',2],['date',$request->date]])->get();
        }
        $bus_list = Bus::where([['company_id', $request->company_id],['status',1]])->get();
        $cnt_bus = 0;
        foreach($bus_list as $bl){
            $cnt_bus = 0;
            foreach($val as $vl){
                if($vl->bus_id == $bl->id){
                    $cnt_bus++; 
                }
            }
            if($cnt_bus == 0){
                $bus[] = $bl;
            }
            
        }
        return response()->json($bus);
    }

    public function check_conductor(Request $request){
        $conductor = array();
        // Check if still available for selected date
        if($request->type){
            if($request->type == 'update'){
                $val = PersonnelSchedule::where([['id','==',$request->ps_id],['status','!=',2],['date',$request->date]])->get();
            }
        }else{
            $val = PersonnelSchedule::where([['status','!=',2],['date',$request->date]])->get();
        }
        $personnel_list = Personnel::where([['company_id', $request->company_id],['status',1],['user_type',2]])->get();
        $cnt_personnel = 0;
        foreach($personnel_list as $pl){
            $cnt_personnel = 0;
            foreach($val as $vl){
                if($vl->conductor_id == $pl->id){
                    $cnt_personnel++; 
                }
            }
            if($cnt_personnel == 0){
                $conductor[] = $pl;
            }
        }
        return response()->json($conductor);
    }

    public function check_operator(Request $request){
        $operator = array();
        // Check if still available for selected date
        if($request->type){
            if($request->type == 'update'){
                $val = PersonnelSchedule::where([['id','==',$request->ps_id],['status','!=',2],['date',$request->date]])->get();
            }
        }else{
            $val = PersonnelSchedule::where([['status','!=',2],['date',$request->date]])->get();
        }
        $personnel_list = Personnel::where([['company_id', $request->company_id],['status',1],['user_type',4]])->get();
        $cnt_personnel = 0;
        foreach($personnel_list as $pl){
            $cnt_personnel = 0;
            foreach($val as $vl){
                if($vl->operator_id == $pl->id){
                    $cnt_personnel++; 
                }
            }
            if($cnt_personnel == 0){
                $operator[] = $pl;
            }
        }
        return response()->json($operator);
    }
}
