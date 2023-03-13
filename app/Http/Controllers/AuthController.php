<?php

namespace App\Http\Controllers;
use App\Models\PersonnelSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Bus;
use App\Models\Reminder;
use App\Models\Status;
use App\Models\Trip;
use App\Models\Position;
use App\Models\Route;
use App\Models\Personnel;
use App\Models\Company;
use App\Models\ViewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
date_default_timezone_set('Asia/Manila');

class AuthController extends Controller
{

    // SEND DATA
    public function login(Request $req){
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
        ];
        $req->validate($rules);
        // find user email in users table
        $user = User::where('email', $req->email)->first();
        // if user email found and password is correct
        if ($user && Hash::check($req->password, $user->password) && $user->user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user,'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Incorrect email or password'];
        return response()->json($response, 400);
    }

    public function users(Request $req){
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
        ];
        $req->validate($rules);
        // User Data
        $user = User::with(['personnel.company:id,company_name'])->where('email', $req->email)->first(); // Company name lng
        $user_type = User::where('email', $req->email)->value('user_type');
        $trip = Trip::where('personnel_id',$user->personnel_id)->get();
        $trip_cnt = count($trip);
        
        if ($user && Hash::check($req->password, $user->password) && $user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user, 'trip_cnt' => $trip_cnt, 'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function dashboard(Request $request){
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();
        $user_type = User::where('email', $request->email)->value('user_type');

        // Personnel Data
        $company_id = Personnel::where('id', $request->personnel_id)->value('company_id');

        // Count Schedule Data
        $sched = PersonnelSchedule::where([['conductor_id', $request->personnel_id], ['status', 1]])->get();
        $count_sched = $sched->count();

        // Count Trips Cancel Data
        $trip_cancel = Trip::where([['personnel_id', $request->personnel_id], ['arrived', 2]])->get();
        $count_cancel = $trip_cancel->count();

        // Count Trips Total Data
        $trip_total = Trip::where([['personnel_id', $request->personnel_id]])->get();
        $count_total = $trip_total->count();

        // Count Trips Duration Total Data
        $trip_duration_total = Trip::where([['personnel_id', $request->personnel_id]])->sum('trip_duration');
        
        // Count Trips Days Total Data
        $sched1 = PersonnelSchedule::where([['conductor_id', $request->personnel_id],['status',2]])->get();
        $trip_days_total = $sched1->count();

        // Reminder Data
        $reminder = Reminder::with('company:id,company_name,logo_path')
        ->where([ ['user_type', $user_type], ['company_id', $company_id] ])
        ->latest('created_at')
        ->first();
        


        // Return
        if ($user && Hash::check($request->password, $user->password) && $user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                'data' =>[
                    'count' => [
                        'count_sched' => strval($count_sched), 
                        'count_cancel' => strval($count_cancel), 
                        'count_total' => strval($count_total), 
                        'count_duration_total' => strval($trip_duration_total), 
                        'count_days_total' => strval($trip_days_total), 
                        'token' => $token
                    ],
                    'user' => $user,
                    'reminder' => $reminder
                ]
                
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function notification(Request $request){
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();
        $user_type = User::where('email', $request->email)->value('user_type');
        $company_id = Personnel::where('id', $request->personnel_id)->value('company_id');

        // Reminder Data
        $reminder = Reminder::with(['company:id,company_name,logo_path','view_message'])
        ->where([ ['user_type', $user_type], ['company_id', $company_id] ])
        ->orderBy('created_at','desc')
        ->get();

        // Return
        if ($user && Hash::check($request->password, $user->password) && $user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                'reminder' => $reminder,
                'token' => $token
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function schedule(Request $request){
        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Personnel Data
        $company_id = Personnel::where('id', $request->personnel_id)->value('company_id');
        $personnel_info = Personnel::where('company_id', $company_id)->get();

        // Personnel Schedule Data
        $assign_sched = PersonnelSchedule::with(['schedule.route','bus','personnel'])->where([
            ['conductor_id', $request->personnel_id], 
            ['date','>=',date("Y/m/d")]
            // ['status', 1]
        ])->get();

        // Return
        if ($personnel_info && $assign_sched && $user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                'assign_sched' => $assign_sched, 
                'personnel_info' => $personnel_info, 
                'token' => $token
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function trip(Request $request){
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Trip Data
        $trip = Trip::with('personnel_schedule.schedule.route')
        ->where([
            ['personnel_id', $request->personnel_id],
            ['arrived','!=',0]
        ])
        ->orderBy('created_at','desc')
        ->get();

        // Return
        if($trip && $user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                'trip' => $trip, 
                'token' => $token
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function trip_schedule(Request $request){
        $title = '';
        // validate inputs
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'personnel_schedule_id' => 'required',
            'max_trips' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Trip Data
        $trip = Trip::where([
            ['personnel_schedule_id', $request->personnel_schedule_id]
        ])->latest('trip_no')->first();

        if($trip){
            if($trip->arrived == 0){
                $title = 'View Ongoing Trip';
            }else if($trip->arrived == 1){
                $title = 'Start Trip';
            }else if($trip->arrived == 2){
                $title = 'Start Trip';
            }
        }else{
            $title = 'Start Trip';
        }

        // Count Arrived Trips
        $cnt = Trip::where([
            ['personnel_schedule_id', $request->personnel_schedule_id],
            ['arrived', 1]
        ])->get();
        $trip_cnt = $cnt->count();

        // Count Cancelled Trips
        $cnt1 = Trip::where([
            ['personnel_schedule_id', $request->personnel_schedule_id],
            ['arrived', 2]
        ])->get();
        $cancelled_cnt = $cnt1->count();

        // Count Ongoing Trips
        $cnt2 = Trip::where([
            ['personnel_schedule_id', $request->personnel_schedule_id],
            ['arrived', 0]
        ])->get();
        $ongoing_cnt = $cnt2->count();

        // Return
        if($title && $user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            if($request->max_trips == $trip_cnt){
                $title = "Not Available";
            }
            $response = [ 
                'data' => [
                    'trip' => $trip, 
                    'title' => $title,
                    'trip_cnt' => $trip_cnt,
                    'cancelled_cnt' => $cancelled_cnt,
                    'ongoing_cnt' => $ongoing_cnt,
                    'token' => $token
                ]
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function status(Request $request){
        $message = '';
        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'trip_id' => 'required'
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Status Data
        $status = Status::where('trip_id', $request->trip_id)->orderBy('created_at','desc')->get();
        if($status){
            $message = ''.$status->count().'';
        }else{
            $message = 'No status updated.';
        }


        // Return
        if($user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                    'message' => $message,
                    'status' => $status, 
                    'token' => $token
                
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function ongoing(Request $request){
        $bus_status = 0;
        $arrive = 0;
        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Trip Data
        $trip = Trip::where([
            ['personnel_id', $request->personnel_id],
            ['arrived',0]
        ])->latest('created_at')->first();
        
        // Return
        if($trip && $user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $arrive = $trip->arrived;
            // Personnel Schedule Data
            $assign_sched = PersonnelSchedule::with(['schedule.route','bus','personnel'])->where([
                ['conductor_id', $request->personnel_id], 
                ['id', $trip->personnel_schedule_id]
            ])->first();

            // Status Data
            $status = Status::where([
                ['trip_id', $trip->id]
            ])->latest('created_at')->value('bus_status');

            if($status){
                $bus_status = $status;
            }else{
                $bus_status = 0;
            }
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                'data' => [
                    'arrived' => $trip->arrived,
                    'trip' => $trip,
                    'assign_sched' => $assign_sched,
                    'bus_status' => $bus_status, 
                    'token' => $token
                ]
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    public function position(Request $request){
        $lat1 = 0;
        $lng1 = 0;
        $lat2 = 0;
        $lng2 = 0;
        $message = '';
        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'trip_id' => 'required'
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        $trip = Trip::where('id',$request->trip_id)->first();
        // Status Data
        // $lat2 = Status::where('trip_id', $request->trip_id)->latest('created_at')->value('latitude');
        // $lng2 = Status::where('trip_id', $request->trip_id)->latest('created_at')->value('longitude');
        // $lat1 = Status::where('trip_id', $request->trip_id)->orderBy('created_at','asc')->value('latitude'); 
        // $lng1 = Status::where('trip_id', $request->trip_id)->orderBy('created_at','asc')->value('longitude');
        $stat = Status::where('trip_id',$request->trip_id)->get();
        $stat2 = Status::where('trip_id',$request->trip_id)->latest('created_at')->first();
        
        if($trip->inverse == 0){
            $lat1 = $trip->personnel_schedule->schedule->route->orig_latitude;
            $lng1 = $trip->personnel_schedule->schedule->route->orig_longitude;
            $lat2 = $trip->personnel_schedule->schedule->route->dest_latitude;
            $lng2 = $trip->personnel_schedule->schedule->route->dest_longitude;
        }else{
            $lat2 = $trip->personnel_schedule->schedule->route->orig_latitude;
            $lng2 = $trip->personnel_schedule->schedule->route->orig_longitude;
            $lat1 = $trip->personnel_schedule->schedule->route->dest_latitude;
            $lng1 = $trip->personnel_schedule->schedule->route->dest_longitude;    
        }

        if(count($stat) != 0){
            $lat1 = Status::where('trip_id',$request->trip_id)->latest('created_at')->value('latitude');
            $lng1 = Status::where('trip_id',$request->trip_id)->latest('created_at')->value('longitude');
        }
        

        // Return
        if($lat1 && $lng1 && $lat2 && $lng2 && $user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [ 
                'position' => [
                    'trip' => $trip,
                    'lat1' => $lat1,
                    'lng1' => $lng1,
                    'lat2' => $lat2,
                    'lng2' => $lng2,
                    'token' => $token,
                ] 
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not fetch data.'];
        return response()->json($response, 400);
    }

    // SAVE DATA TO DB
    public function update_profile(Request $request){

        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'contact_no' => 'required',
            'address' => 'required|string',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();
        // $user_type = User::where('email', $request->email)->value('user_type');
        

        // Return
        if ($user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $old_data = Personnel::where('id', $request->personnel_id)->first();
            if($old_data->contact_no == $request->contact_no && $old_data->address == $request->address){
                $response = ['message' => 'No new values added.'];
                return response()->json($response, 400);
            }
            else{
                Personnel::where('id', $request->personnel_id)->update(
                    array(
                        'contact_no' => $request->contact_no,
                        'address' => $request->address,
                        'updated_at' => now(),
                    )
                );
                $token = $user->createToken('Personal Access Token')->plainTextToken;
                $response = ['user' => $user,'token' => $token];
                return response()->json($response, 200);
            }
        }
        $response = ['message' => 'Could not save data to database.'];
        return response()->json($response, 400);
    }

    public function update_password(Request $request){

        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'current_password' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();
        
        // Check current password if correct
        $pass = User::where('personnel_id', $request->personnel_id)->value('password');
        if(!password_verify($request->current_password, $pass)){
            $response = ['message' => 'The current password is incorrect.'];
            return response()->json($response, 400);
        }// Check if its an old password
        else if(password_verify($request->new_password, $pass)){
            $response = ['message' => 'The new password is your current password.'];
            return response()->json($response, 400);
        }else{
            $rules2 = [
                'new_password' => 'required|min:8',
                'retype_password' => 'required|required_with:new_password|same:new_password',
            ];
            $request->validate($rules2);
            if($request->new_password == $request->retype_password){
                // Update Password in DB (Company Table)
                DB::table('account')->where('personnel_id', $request->personnel_id)->update([
                    'password' => $request->new_password
                ]);
    
                // Update Password in DB (Users Table)
                DB::table('users')->where('personnel_id', $request->personnel_id)->update([
                    'password' => bcrypt($request->new_password)
                ]);
    
                // Return
                $token = $user->createToken('Personal Access Token')->plainTextToken;
                $response = ['user' => $user,'token' => $token];
                return response()->json($response, 200);
            }
            
        }

        

        

        // Return
        // if ($user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
        //     $old_data = Personnel::where('id', $request->personnel_id)->first();
        //     if($old_data->age == $request->age && $old_data->contact_no == $request->contact_no && 
        //     $old_data->address == $request->address){
        //         $response = ['message' => 'No new values added.'];
        //         return response()->json($response, 400);
        //     }
        //     else{
        //         Personnel::where('id', $request->personnel_id)->update(
        //             array(
        //                 'age' => $request->age,
        //                 'contact_no' => $request->contact_no,
        //                 'address' => $request->address,
        //                 'updated_at' => now(),
        //             )
        //         );
        //         $token = $user->createToken('Personal Access Token')->plainTextToken;
        //         $response = ['user' => $user,'token' => $token];
        //         return response()->json($response, 200);
        //     }
        // }
        // $response = ['message' => 'Could not save data to database.'];
        // return response()->json($response, 400);
    }

    public function update_status(Request $request){
        $lat = 0;
        $lng = 0;

        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'personnel_schedule_id' => 'required',
            'bus_status' => 'required',
            'trip_id' => 'required',
            'max_trips' => 'required'
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Trip Data
        // $trip = Trip::where('id', $request->trip_id)->first();

        // Bus Data
        $bus_id = PersonnelSchedule::where('id', $request->personnel_schedule_id)->value('bus_id');

        // Position Data
        $position = Position::where('bus_id', $bus_id)->latest('created_at')->first();
        $latitude = Position::where('bus_id', $bus_id)->latest('created_at')->value('latitude');
        $longitude = Position::where('bus_id', $bus_id)->latest('created_at')->value('longitude');

        if($position){
            $lat = $latitude;
            $lng = $longitude;
        }else{
            $lat = 0;
            $lng = 0;
        }

        // Return
        if ($user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            $data = new Status(); // Create New Status
            $data->trip_id = $request->trip_id;
            $data->bus_status = $request->bus_status;
            $data->latitude = $lat;
            $data->longitude = $lng;
            $data->save();

            // Get Trip Duration
            $created_at = Trip::where('id',$request->trip_id)->value('created_at');
            $updated_at = $data->created_at;
            $to_time = strtotime($created_at);
            $from_time = strtotime($updated_at);
            $minutes = round(abs($to_time - $from_time) / 60,2);
            if($request->bus_status == 5){
                Trip::where('id', $request->trip_id)->update(
                    array(
                        'arrived' => 1, // Arrived
                        'trip_duration' => $minutes,
                        'updated_at' => now(),
                    )
                );
                $arr = 'The trip has arrived.';

                // If reached maximum trips
                $tp = Trip::where([
                    ['personnel_schedule_id', $request->personnel_schedule_id],
                    ['arrived',1]
                ])->get();
                $trip_cnt = $tp->count();
                if($request->max_trips == $trip_cnt){
                    PersonnelSchedule::where('id', $request->personnel_schedule_id)->update(
                        array(
                            'status' => 3, // Personnel Schedule Inactive
                            'updated_at' => now(),
                        )
                    );
                }
            } else if ($request->bus_status == 1){
                $arr = 'The trip is NOT yet departed.';
            } else if ($request->bus_status == 3){
                $arr = 'The trip has departed.';
            } else if ($request->bus_status == 4){
                Trip::where('id', $request->trip_id)->update(
                    array(
                        'arrived' => 2, // Canceled
                        'trip_duration' => $minutes,
                        'updated_at' => now(),
                    )
                );
                $arr = 'The trip was canceled.';
            } else {
                Trip::where('id', $request->trip_id)->update(
                    array(
                        'arrived' => 0, // Not Yet Arrived
                        'updated_at' => now(),
                    )
                );
                $arr = 'The trip is NOT yet arrived.';
            }

            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [
                'message' => 'True = '.$request->bus_status, 
                'minutes' => $minutes,
                'arrived' => $arr, 
                'position' => $position, 
                'status' => $data,
                'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not save data to database.'];
        return response()->json($response, 400);        
    }

    public function create_trip(Request $request){
        $inverse = 0;
        $trip_no = 0;
        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'personnel_schedule_id' => 'required',
            'trip_id' => 'required',
            'trip_cnt' => 'required',
            'ongoing_cnt' => 'required',
            'max_trips' => 'required',
            'inverse' => 'required',
            'departure' => 'required'
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();

        // Trip Data
        if($request->trip_id != 0){
            $trip = Trip::where('id', $request->trip_id)->first();
            $trip_no = Trip::where('id', $request->trip_id)->value('trip_no')+1;
        
                // if($trip->inverse == 0){
                //     $inverse = 1;
                // }else if($trip->inverse == 1){
                //     $inverse = 0;
            
        }else{
            // $inverse = 0;
            $trip_no = 1;
        }
        
        // Return
        if ($user && Hash::check($request->password, $user->password) && $user->user_type == 2) {
            if($request->trip_cnt != $request->max_trips && $request->ongoing_cnt == 0 && $request->inverse != 2){
                // $datetime = date($request->departure);
                // $time = $datetime->format("h:i:s");
                // $time = date("h:i:", strtotime($request->departure));
                $data = new Trip();
                $data->personnel_schedule_id = $request->personnel_schedule_id;
                $data->personnel_id = $request->personnel_id;
                $data->trip_no = $trip_no;
                $data->inverse = $request->inverse;
                $data->trip_duration = 0;
                $data->arrived = 0;
                $data->departure = $request->departure;
                $data->save();
                $trip_data = $data;
                $trip_status = 0;
                $message = "New trip created";
            }else if($request->ongoing_cnt == 1 && $request->trip_id != 0){
                $trip_data = $trip;
                $trip_status = Status::where('trip_id',$request->trip_id)->latest('created_at')->value('bus_status');
                $message = "Ongoing trip used";
            }
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [
                'data' => [
                    'message' => $message, 
                    'trip_status' => $trip_status,
                    'trip' => $trip_data,
                    'token' => $token
                ]
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not save data to database.'];
        return response()->json($response, 400);        
    }

    public function create_view(Request $request){
        // Validation Rules
        $rules = [
            'email' => 'required',
            'password' => 'required|string',
            'personnel_id' => 'required',
            'reminder_id' => 'required',
            'status' => 'required',
        ];
        $request->validate($rules);

        // User Data
        $user = User::where('email', $request->email)->first();
        
        // Return
        if ($user && Hash::check($request->password, $user->password) && $user->user_type == 2) {

            $data = new ViewMessage();
            $data->personnel_id = $request->personnel_id;
            $data->reminder_id = $request->reminder_id;
            $data->status = $request->status;
            $data->save();

            $message = "Message Viewed";
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [
                'data' => [
                    'message' => $message, 
                    'token' => $token
                ]
            ];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Could not save data to database.'];
        return response()->json($response, 400);        
    }

}
 