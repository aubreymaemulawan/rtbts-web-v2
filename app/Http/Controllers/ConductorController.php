<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonnelSchedule;
use App\Models\Company;
use App\Models\Bus;
use App\Models\Personnel;
use App\Models\Route;
date_default_timezone_set('Asia/Manila');

class ConductorController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $personnel_schedule = PersonnelSchedule::all();
        $company = Company::all();
        $bus = Bus::all();
        $personnel = Personnel::all();
        $route = Route::all();
        return view('conductor.dashboard',compact('personnel_schedule','company','bus','personnel','route'));
    }
}
