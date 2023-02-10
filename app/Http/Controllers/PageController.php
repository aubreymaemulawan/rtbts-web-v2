<?php

namespace App\Http\Controllers;
use App\Events\GPSMoved;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Bus;
use App\Models\Company;
use App\Models\Discount;
use App\Models\Fare;
use App\Models\Location;
use App\Models\Personnel;
use App\Models\PersonnelSchedule;
use App\Models\Position;
use App\Models\Reminder;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Trip;
use App\Models\City;
use App\Models\Province;
use PDF;

class PageController extends Controller
{
    // Need Auth to go to routes
    public function __construct() {
        $this->middleware('auth');
    }
    
    // Admin Views
    public function account(){
        $account = Account::orderBy('created_at','desc')->get();
        $personnel = Personnel::all();
        $company = Company::all();
        return view('admin.account',compact('account','personnel','company'));
    }

    public function bus(){
        $bus = Bus::orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.bus',compact('bus','company'));
    }

    public function company(){
        $data = Company::all();
        return view('admin.company',compact('data'));
    }

    public function discount(){
        $data = Discount::all();
        return view('admin.discount',compact('data'));
    }

    public function fare(){
        $fare = Fare::orderBy('created_at','desc')->get();
        $route = Route::all();
        $company = Company::all();
        return view('admin.fare',compact('fare','route','company'));
    }

    public function location(){
        $data = Location::all();
        return view('admin.location',compact('data'));
    }

    public function personnel(){
        $personnel = Personnel::orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.personnel',compact('personnel','company'));
    }

    public function personnel_schedule(){
        $personnel_schedule = PersonnelSchedule::orderBy('date','desc')->get();
        $trip = Trip::where('arrived',0)->get();
        $schedule = Schedule::all();
        $bus = Bus::all();
        $personnel = Personnel::all();
        $company = Company::all();
        return view('admin.personnel-schedule',compact('personnel_schedule','schedule','bus','personnel','company','trip'));
    }

    public function position(){
        $position = Position::all();
        $bus = Bus::all();
        return view('admin.position',compact('position','bus'));
    }

    public function announcement(Request $request){
        $reminder = Reminder::where('company_id',$request->user()->company_id)->orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.announcement',compact('reminder','company'));
    }

    public function route(){
        $route = Route::orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.route',compact('route','company'));
    }

    public function schedule(){
        $schedule = Schedule::all();
        $personnel_schedule = PersonnelSchedule::all();
        $company = Company::all();
        $route = Route::all();
        return view('admin.schedule',compact('schedule','personnel_schedule','company','route'));
    }

    public function status(){
        $status = Status::all();
        $trip = Trip::all();
        $company = Company::all();
        return view('admin.status',compact('status','trip','company'));
    }

    public function trip(){
        $trip = Trip::orderBy('created_at','desc')->get();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('admin.trip',compact('trip','schedule','company'));
    }

    public function track(Request $request){ //copy
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
            if($tr->personnel_schedule->schedule->company_id == $request->user()->company_id){
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
        echo "<script>console.log(".json_encode($ongoing_trip).")</script>";
        $company = Company::all();
        return view('admin.track',compact('company','ongoing_trip'));
    }

    public function profile(){
        $company = Company::all();
        $city = City::all();
        $province = Province::all();
        return view('admin.profile',compact('company','city','province',));
    }

    public function email(){
        $company = Company::all();
        return view('admin.email',compact('company'));
    }

    public function password(){
        $company = Company::all();
        return view('admin.password',compact('company'));
    }



    // Dispatcher Views
    public function dispatcher_schedule(){
        $personnel = Personnel::all();
        $schedule = Schedule::all();
        $trip = Trip::all();
        $personnel_schedule = PersonnelSchedule::orderBy('date','desc')->get();
        $company = Company::all();
        $route = Route::all();
        return view('dispatcher.schedule',compact('personnel','schedule','personnel_schedule','company','route','trip'));
    }

    public function dispatcher_trip(){
        $personnel = Personnel::all();
        $trip = Trip::all();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('dispatcher.trip',compact('personnel','trip','schedule','company'));
    }

    public function dispatcher_announcement(Request $request){
        $personnel_id = $request->user()->personnel_id;
        $com_id = Personnel::where('id',$personnel_id)->value('company_id');

        $personnel = Personnel::all();
        $company = Company::all();
        $comp_name = Company::where('id',$com_id)->value('company_name');
        $announce = Reminder::where([['company_id', $com_id],['user_type',1]])->orWhere('user_type',3)->orWhere('user_type',6)->orderBy('created_at','desc')->get();
        return view('dispatcher.announcement',compact('personnel','announce','company','comp_name'));
    }
    
    public function dispatcher_profile(){
        $personnel = Personnel::all();
        $company = Company::all();
        $city = City::all();
        $province = Province::all();
        return view('dispatcher.profile',compact('personnel','company','city','province',));
    }

    public function dispatcher_password(){
        $personnel = Personnel::all();
        return view('dispatcher.password',compact('personnel'));
    }


    // Operator Views
    public function operator_schedule(){
        $personnel = Personnel::all();
        $schedule = Schedule::all();
        $trip = Trip::all();
        $personnel_schedule = PersonnelSchedule::orderBy('date','desc')->get();
        $company = Company::all();
        $route = Route::all();
        return view('operator.schedule',compact('personnel','schedule','personnel_schedule','company','route','trip'));
    }

    public function operator_trip(){
        $personnel = Personnel::all();
        $trip = Trip::all();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('operator.trip',compact('personnel','trip','schedule','company'));
    }

    public function operator_announcement(Request $request){
        $personnel_id = $request->user()->personnel_id;
        $com_id = Personnel::where('id',$personnel_id)->value('company_id');

        $personnel = Personnel::all();
        $company = Company::all();
        $comp_name = Company::where('id',$com_id)->value('company_name');
        $announce = Reminder::where([['company_id', $com_id],['user_type',1]])->orWhere('user_type',4)->orWhere('user_type',6)->orderBy('created_at','desc')->get();
        return view('operator.announcement',compact('personnel','announce','company','comp_name'));
    }
    
    public function operator_profile(){
        $personnel = Personnel::all();
        $company = Company::all();
        $city = City::all();
        $province = Province::all();
        return view('operator.profile',compact('personnel','company','city','province',));
    }

    public function operator_password(){
        $personnel = Personnel::all();
        return view('operator.password',compact('personnel'));
    }

}
 