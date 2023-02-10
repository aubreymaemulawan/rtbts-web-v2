<?php

namespace App\Http\Controllers;
use App\Events\GPSMoved;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Trip;
use App\Models\PersonnelSchedule;
use App\Models\Position;
use App\Models\Status;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Fare;
use App\Models\Reminder;
use DateTime;
date_default_timezone_set('Asia/Manila');

class MapsController extends Controller
{ 

    // Maps Views

    public function landing_page(){
        $date = strtotime("+1 day");
        $schedule = Schedule::all();
        $route = Route::all();
        $fare = Fare::all();
        $company = Company::all();
        $trip = Trip::where('arrived',0)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        $status = Status::all();
        $persched_today = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d',$date))->get();
        $announce = Reminder::where('user_type',1)->orWhere('user_type',5)->get();
        if(count($announce)==0){
            $announce = 0;
        }
        return view('landing-page',compact('schedule','fare','company','route','trip','status','announce','persched','persched_today'));
    }

    public function trip_page($persched_id){
        $trip = Trip::where('personnel_schedule_id',$persched_id)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        return view('trip-page',compact('trip','persched_id'));
    }

    public function admin_map_page($trip_id){
        $str = array();
        $dep ='';
        $trip = Trip::with('personnel_schedule')->where('id',$trip_id)->first();
        $status = Status::where('trip_id',$trip_id)->latest('created_at')->first();
        $departure = Status::where([['bus_status',3],['trip_id',$trip_id]])->first();
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        $bus_id = $trip->personnel_schedule->bus_id;
        $from_to_location = $trip->personnel_schedule->schedule->route->from_to_location;
        $str = explode("-",$from_to_location);
        $origin = $str[0];
        $destination = $str[1];
        $position = Position::where('bus_id',$trip->personnel_schedule->bus_id)->latest('created_at')->first();
        
        if($trip->inverse == 1){
            $dest_latitude = $trip->personnel_schedule->schedule->route->orig_latitude;
            $dest_longitude = $trip->personnel_schedule->schedule->route->orig_longitude;
            $orig_latitude = $trip->personnel_schedule->schedule->route->dest_latitude;
            $orig_longitude = $trip->personnel_schedule->schedule->route->dest_longitude;
        }else if($trip->inverse == 0){
            $orig_latitude = $trip->personnel_schedule->schedule->route->orig_latitude;
            $orig_longitude = $trip->personnel_schedule->schedule->route->orig_longitude;
            $dest_latitude = $trip->personnel_schedule->schedule->route->dest_latitude;
            $dest_longitude = $trip->personnel_schedule->schedule->route->dest_longitude;
        }
        if($position){
            $orig_latitude = $position->latitude;
            $orig_longitude = $position->longitude;
        }
        if(empty($departure)){
            if($trip){
                $dep = $trip->departure;
            }else{
                $dep = 'N/A';
            }
        }else{
            $date = new DateTime($departure->created_at);
            $dep = $date->format('g:i a');
        }
        return view('admin.admin-map-page',compact(
            'trip_id',
            'trip',
            'status',
            'persched',
            'bus_id',
            'orig_latitude','orig_longitude',
            'dest_latitude','dest_longitude',
            'origin','destination',
            'dep',
        ));
    }

    public function map_page($trip_id){
        $str = array();
        $dep ='';
        $trip = Trip::with('personnel_schedule')->where('id',$trip_id)->first();
        $status = Status::where('trip_id',$trip_id)->latest('created_at')->first();
        $departure = Status::where([['bus_status',3],['trip_id',$trip_id]])->first();
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        $bus_id = $trip->personnel_schedule->bus_id;
        $from_to_location = $trip->personnel_schedule->schedule->route->from_to_location;
        $str = explode("-",$from_to_location);
        $origin = $str[0];
        $destination = $str[1];
        
        if($trip->inverse == 1){
            $dest_latitude = $trip->personnel_schedule->schedule->route->orig_latitude;
            $dest_longitude = $trip->personnel_schedule->schedule->route->orig_longitude;
            $orig_latitude = $trip->personnel_schedule->schedule->route->dest_latitude;
            $orig_longitude = $trip->personnel_schedule->schedule->route->dest_longitude;
        }else if($trip->inverse == 0){
            $orig_latitude = $trip->personnel_schedule->schedule->route->orig_latitude;
            $orig_longitude = $trip->personnel_schedule->schedule->route->orig_longitude;
            $dest_latitude = $trip->personnel_schedule->schedule->route->dest_latitude;
            $dest_longitude = $trip->personnel_schedule->schedule->route->dest_longitude;
        }
        if(empty($departure)){
            if($trip){
                $dep = $trip->departure;
            }else{
                $dep = 'N/A';
            }
        }else{
            $date = new DateTime($departure->created_at);
            $dep = $date->format('g:i a');
        }
        return view('map-page',compact(
            'trip_id',
            'trip',
            'status',
            'persched',
            'bus_id',
            'orig_latitude','orig_longitude',
            'dest_latitude','dest_longitude',
            'origin','destination',
            'dep',
        ));
    }
    
    public function gps_maps(Request $request){
        // Validation Rules
        $request->validate([
            'api_key' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'speed' => 'required',
            'bus_id' => 'required',
        ]);
        $api_key = 'Qwerty143';
        $cnt = 0;
        $bus_id = Bus::where('id', $request->bus_id)->first();

        if($bus_id){
            if($api_key == $request->api_key){

                // Check if there is an Ongoing Trip
                $ongoing = Trip::where('arrived',0)->get();
                foreach($ongoing as $on){
                    if($on->personnel_schedule->bus_id == $request->bus_id){
                        $cnt++;
                    }
                }
    
                if($cnt != 0){
                    // Event
                    event(new GPSMoved($request->lat, $request->lng, $request->bus_id));
    
                    // Create Data in DB (Position Table)
                    $data = new Position();
                    $data->latitude = $request->lat;
                    $data->longitude = $request->lng;
                    $data->speed = $request->speed;
                    $data->bus_id = $request->bus_id;
    
                    // Save to DB
                    $data->save();
    
                    $response = "There is an Ongoing Trip with this Bus ID. GPS Successfully saved to database.";
                    return response()->json($response, 200);
                }else{
                    $response = "There is NO Ongoing Trip with this Bus ID.";
                    return response()->json($response, 400);
                }
            }else{
                $response = "Api Key is invalid.";
                return response()->json($response, 400);
            }
        }else{
            $response = "Bus ID is invalid.";
            return response()->json($response, 400);
        }

    }

    public function track_position(Request $request){ //copy
        $request->validate([
            'company_id' => 'required'
        ]);
        $bus_id = 0;
        $bus_no = 0;
        $bus_type = 0;
        $bus_color = 0;
        $trip_id = 0;
        $trip_no = 0;
        $from_to_location = 0;
        $orig_latitude = 0;
        $orig_longitude = 0;
        $ongoing_trip = array();
        $trip_info = array();
        $str = '';
        $origin = '';
        $destination = '';        
        $bus_status = '';
        $trip = Trip::where('arrived',0)->get();
        foreach($trip as $key=>$tr){
            if($tr->personnel_schedule->schedule->company_id == $request->company_id){
                $status = Status::where('trip_id',$tr->id)->latest('created_at')->first();
                $bus_id = $tr->personnel_schedule->bus_id;
                $position = Position::where('bus_id', $bus_id)->latest('created_at')->first();
                if(!$status){
                    $bus_status = 'N/A';
                    $status_created = '';
                }else{
                    $bus_status = $status->bus_status;
                    $status_created = $status->created_at;
                }
                $str = explode("-",$tr->personnel_schedule->schedule->route->from_to_location);
                $origin = $str[0];
                $destination = $str[1];
                if($tr->inverse == 1){
                    $from_to_location = $destination.' - '.$origin;
                }else{
                    $from_to_location = $origin.' - '.$destination;
                }
                $orig_latitude = $position->latitude;
                $orig_longitude = $position->longitude;
                $bus_no = $tr->personnel_schedule->bus->bus_no;
                if($tr->personnel_schedule->bus->bus_type == 1){
                    $bus_type = "Airconditioned";
                }else{
                    $bus_type = "Non-Airconditioned";
                }
                $bus_color = $tr->personnel_schedule->bus->color;
                $trip_id = $tr->id;
                $trip_no = $tr->trip_no;
                $ongoing_trip[$key] = array($from_to_location, $orig_latitude, $orig_longitude, $bus_id, $bus_no, $bus_type, $bus_color, $trip_id, $trip_no, $bus_status, $status_created);
            }
        }
        $company = Company::all();
        return response()->json($ongoing_trip);
    }
    
    public function departure(Request $request){
        $dep = '';
        $departure = Status::where([['bus_status',3],['trip_id',$request->trip_id]])->first();
        if(empty($departure)){
            $depo = Trip::where('id', $request->trip_id)->value('departure');
            if($depo){
                $dep = $depo;
            }else{
                $dep = 'N/A';
            }
        }else{
            $date = new DateTime($departure->created_at);
            $dep = $date->format('g:i a');
        }
        return response()->json($dep); 
    }

} 
