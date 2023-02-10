<?php

namespace App\Http\Controllers;

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
date_default_timezone_set('Asia/Manila');

class DispatcherController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $cnt1 = 0; $cnt2 = 0; $cnt3 = 0; $cnt4 = 0; $cnt5 = 0; $cnt6 = 0; $cnt7 = 0; $cnt8 = 0; $cnt9 = 0; $cnt10 = 0; $cnt11 = 0; $cnt12 = 0; 
        $cnt13 = 0; $cnt14 = 0; $cnt15 = 0; $cnt16 = 0; $cnt17 = 0; $cnt18 = 0; $cnt19 = 0; $cnt20 = 0; $cnt21 = 0; $cnt22 = 0; $cnt23 = 0; $cnt24 = 0; 
        $cnt25 = 0; $cnt26 = 0; $cnt27 = 0; $cnt28 = 0; $cnt29 = 0; $cnt30 = 0; $cnt31 = 0; $cnt32 = 0; $cnt33 = 0; $cnt34 = 0; $cnt35 = 0; $cnt36 = 0; 
        $dur1 = 0; $dur2 = 0; $dur3 = 0; $dur4 = 0; $dur5 = 0; $dur6 = 0; $dur7 = 0; $dur8 = 0; $dur9 = 0; $dur10 = 0; $dur11 = 0; $dur12 = 0; 
        $total_minutes = 0;
        $ongoing_trip = array();
        $cancelled_trip = array();
        $arrived_trip = array();
        $duration_trip = array();
        $company = Company::all();
        $personnel_id = $request->user()->personnel_id;
        // Trips
        $trips = Trip::where('arrived',1)->get();
        $trip_today = Trip::where('arrived',1)->whereDate('created_at', '=', date('Y-m-d'))->get();
        $trip_month = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', date('m'))->get();
        $trip_year = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->get();

        // Personnel Schedule
        $perscheds = PersonnelSchedule::where('status',1)->orWhere('status',3)->get();
        $persched_today = PersonnelSchedule::where([['date', '=', date('Y-m-d')],['status',1]])->orWhere([['date', '=', date('Y-m-d')],['status',3]])->get();
        $persched_month = PersonnelSchedule::where(function ($query1) {
            $query1->where('status',1)->whereYear('date', '=', date('Y'))->whereMonth('date', '=', date('m'));
                })->orWhere(function ($query2) {
            $query2->where('status',3)->whereYear('date', '=', date('Y'))->whereMonth('date', '=', date('m'));
                })->get();
        $persched_year = PersonnelSchedule::where(function ($query3) {
            $query3->where('status',1)->whereYear('date', '=', date('Y'));
                })->orWhere(function ($query4) {
            $query4->where('status',3)->whereYear('date', '=', date('Y'));
                })->get();

        // Trip Chart
        $jan_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->get();
        $jan_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->get();
        $jan_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->get();

        $feb_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->get();
        $feb_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->get();
        $feb_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->get();

        $mar_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->get();
        $mar_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->get();
        $mar_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->get();

        $apr_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->get();
        $apr_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->get();
        $apr_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->get();

        $may_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->get();
        $may_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->get();
        $may_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->get();

        $jun_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->get();
        $jun_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->get();
        $jun_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->get();

        $jul_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->get();
        $jul_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->get();
        $jul_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->get();

        $aug_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->get();
        $aug_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->get();
        $aug_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->get();

        $sep_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->get();
        $sep_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->get();
        $sep_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->get();

        $oct_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->get();
        $oct_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->get();
        $oct_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->get();

        $nov_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->get();
        $nov_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->get();
        $nov_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->get();

        $dec_ongoing = Trip::where('arrived',0)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->get();
        $dec_arrived = Trip::where('arrived',1)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->get();
        $dec_cancelled = Trip::where('arrived',2)->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->get();

        foreach($jan_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt1++;
            }
        }
        foreach($feb_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt2++;
            }
        }
        foreach($mar_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt3++;
            }
        }
        foreach($apr_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt4++;
            }
        }
        foreach($may_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt5++;
            }
        }
        foreach($jun_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt6++;
            }
        }
        foreach($jul_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt7++;
            }
        }
        foreach($aug_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt8++;
            }
        }
        foreach($sep_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt9++;
            }
        }
        foreach($oct_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt10++;
            }
        }
        foreach($nov_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt11++;
            }
        }
        foreach($dec_ongoing as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt12++;
            }
        }

        $ongoing_trip[0] = $cnt1;
        $ongoing_trip[1] = $cnt2;
        $ongoing_trip[2] = $cnt3;
        $ongoing_trip[3] = $cnt4;
        $ongoing_trip[4] = $cnt5;
        $ongoing_trip[5] = $cnt6;
        $ongoing_trip[6] = $cnt7;
        $ongoing_trip[7] = $cnt8;
        $ongoing_trip[8] = $cnt9;
        $ongoing_trip[9] = $cnt10;
        $ongoing_trip[10] = $cnt11;
        $ongoing_trip[11] = $cnt12;

        foreach($jan_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt13++;
            }
        }
        foreach($feb_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt14++;
            }
        }
        foreach($mar_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt15++;
            }
        }
        foreach($apr_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt16++;
            }
        }
        foreach($may_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt17++;
            }
        }
        foreach($jun_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt18++;
            }
        }
        foreach($jul_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt19++;
            }
        }
        foreach($aug_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt20++;
            }
        }
        foreach($sep_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt21++;
            }
        }
        foreach($oct_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt22++;
            }
        }
        foreach($nov_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt23++;
            }
        }
        foreach($dec_arrived as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt24++;
            }
        }
        $arrived_trip[0] = $cnt13;
        $arrived_trip[1] = $cnt14;
        $arrived_trip[2] = $cnt15;
        $arrived_trip[3] = $cnt16;
        $arrived_trip[4] = $cnt17;
        $arrived_trip[5] = $cnt18;
        $arrived_trip[6] = $cnt19;
        $arrived_trip[7] = $cnt20;
        $arrived_trip[8] = $cnt21;
        $arrived_trip[9] = $cnt22;
        $arrived_trip[10] = $cnt23;
        $arrived_trip[11] = $cnt24;

        foreach($jan_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt25++;
            }
        }
        foreach($feb_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt26++;
            }
        }
        foreach($mar_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt27++;
            }
        }
        foreach($apr_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt28++;
            }
        }
        foreach($may_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt29++;
            }
        }
        foreach($jun_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt30++;
            }
        }
        foreach($jul_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt31++;
            }
        }
        foreach($aug_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt32++;
            }
        }
        foreach($sep_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt33++;
            }
        }
        foreach($oct_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt34++;
            }
        }
        foreach($nov_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt35++;
            }
        }
        foreach($dec_cancelled as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $cnt36++;
            }
        }

        $cancelled_trip[0] = $cnt25;
        $cancelled_trip[1] = $cnt26;
        $cancelled_trip[2] = $cnt27;
        $cancelled_trip[3] = $cnt28;
        $cancelled_trip[4] = $cnt29;
        $cancelled_trip[5] = $cnt30;
        $cancelled_trip[6] = $cnt31;
        $cancelled_trip[7] = $cnt32;
        $cancelled_trip[8] = $cnt33;
        $cancelled_trip[9] = $cnt34;
        $cancelled_trip[10] = $cnt35;
        $cancelled_trip[11] = $cnt36;

        // Trip Duration
        $bus_trip = Trip::whereYear('created_at', '=', date('Y'))->get();
        foreach($bus_trip as $bt){
            if($bt->personnel_schedule->dispatcher_id == $personnel_id){
                $total_minutes += $bt->trip_duration;
            }
        }
        $jan_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 1)->get();
        $feb_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 2)->get();
        $mar_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 3)->get();
        $apr_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 4)->get();
        $may_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 5)->get();
        $jun_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 6)->get();
        $jul_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 7)->get();
        $aug_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 8)->get();
        $sep_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 9)->get();
        $oct_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 10)->get();
        $nov_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 11)->get();
        $dec_duration = Trip::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', 12)->get();

        foreach($jan_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur1 += $val->trip_duration;
            }
        }
        foreach($feb_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur2 += $val->trip_duration;
            }
        }
        foreach($mar_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur3 += $val->trip_duration;
            }
        }
        foreach($apr_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur4 += $val->trip_duration;
            }
        }
        foreach($may_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur5 += $val->trip_duration;
            }
        }
        foreach($jun_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur6 += $val->trip_duration;
            }
        }
        foreach($jul_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur7 += $val->trip_duration;
            }
        }
        foreach($aug_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur8 += $val->trip_duration;
            }
        }
        foreach($sep_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur9 += $val->trip_duration;
            }
        }
        foreach($oct_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur10 += $val->trip_duration;
            }
        }
        foreach($nov_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur11 += $val->trip_duration;
            }
        }
        foreach($dec_duration as $val){
            if($val->personnel_schedule->dispatcher_id == $personnel_id){
                $dur12 += $val->trip_duration;
            }
        }
        $duration_trip[0] = $dur1;
        $duration_trip[1] = $dur2;
        $duration_trip[2] = $dur3;
        $duration_trip[3] = $dur4;
        $duration_trip[4] = $dur5;
        $duration_trip[5] = $dur6;
        $duration_trip[6] = $dur7;
        $duration_trip[7] = $dur8;
        $duration_trip[8] = $dur9;
        $duration_trip[9] = $dur10;
        $duration_trip[10] = $dur11;
        $duration_trip[11] = $dur12;

        $personnel = Personnel::all();
        $com_id = Personnel::where('id',$personnel_id)->value('company_id');
        $announce = Reminder::where([['company_id', $com_id],['user_type',1]])->orWhere('user_type',3)->orWhere('user_type',6)->latest('created_at')->first();
        if($announce==null ){
            $announce = 0;
        }

        return view('dispatcher.dashboard',compact(
            'company','personnel',
            'trips','trip_today', 'trip_month', 'trip_year',
            'perscheds','persched_today', 'persched_month', 'persched_year',
            'ongoing_trip', 'arrived_trip', 'cancelled_trip',
            'total_minutes', 'duration_trip',
            'announce'
        ));
    }

}
