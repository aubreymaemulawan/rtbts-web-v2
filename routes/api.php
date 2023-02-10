<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PersonnelScheduleController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\FeedbackController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Send Data to Mobile App
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/users', [AuthController::class, 'users']);
Route::post('/auth/schedule', [AuthController::class, 'schedule']);
Route::post('/auth/trip', [AuthController::class, 'trip']);
Route::post('/auth/dashboard', [AuthController::class, 'dashboard']);
Route::post('/auth/notification', [AuthController::class, 'notification']);
Route::post('/auth/trip_schedule', [AuthController::class, 'trip_schedule']);
Route::post('/auth/status', [AuthController::class, 'status']);
Route::post('/auth/ongoing', [AuthController::class, 'ongoing']);
Route::post('/auth/position', [AuthController::class, 'position']);

//Send GPS from Device
Route::post('/auth/gps_maps', [MapsController::class, 'gps_maps']);

//Save Data to DB from Mobile App
Route::post('/auth/update_profile', [AuthController::class, 'update_profile']);
Route::post('/auth/update_password', [AuthController::class, 'update_password']);
Route::post('/auth/update_status', [AuthController::class, 'update_status']);
Route::post('/auth/create_trip', [AuthController::class, 'create_trip']);
Route::post('/auth/create_view', [AuthController::class, 'create_view']);

//Feedback
Route::match(['get','post',], 'feedback/create', [FeedbackController::class,'create']);

//Account
Route::match(['get','post',], 'account/list', [AccountController::class,'list']);
Route::match(['get','post',], 'account/items', [AccountController::class,'items']);
Route::match(['get','post',], 'account/create', [AccountController::class,'create']);
Route::match(['get','post',], 'account/update', [AccountController::class,'update']);
Route::match(['get','post',], 'account/delete', [AccountController::class,'delete']);
Route::match(['get','post',], 'account/find', [AccountController::class,'find']);

//Bus
Route::match(['get','post',], 'bus/list', [BusController::class,'list']);
Route::match(['get','post',], 'bus/items', [BusController::class,'items']);
Route::match(['get','post',], 'bus/create', [BusController::class,'create']);
Route::match(['get','post',], 'bus/update', [BusController::class,'update']);
Route::match(['get','post',], 'bus/delete', [BusController::class,'delete']);

//Company
Route::match(['get','post',], 'company/list', [CompanyController::class,'list']);
Route::match(['get','post',], 'company/items', [CompanyController::class,'items']);
Route::match(['get','post',], 'company/create', [CompanyController::class,'create']);
Route::match(['get','post',], 'company/update', [CompanyController::class,'update']);
Route::match(['get','post',], 'company/delete', [CompanyController::class,'delete']);
Route::match(['get','post',], 'company/update_password', [CompanyController::class,'update_password']);
Route::match(['get','post',], 'company/update_email', [CompanyController::class,'update_email']);

//Discount
Route::match(['get','post',], 'discount/list', [DiscountController::class,'list']);
Route::match(['get','post',], 'discount/items', [DiscountController::class,'items']);
Route::match(['get','post',], 'discount/create', [DiscountController::class,'create']);
Route::match(['get','post',], 'discount/update', [DiscountController::class,'update']);
Route::match(['get','post',], 'discount/delete', [DiscountController::class,'delete']);

//Fare
Route::match(['get','post',], 'fare/list', [FareController::class,'list']);
Route::match(['get','post',], 'fare/items', [FareController::class,'items']);
Route::match(['get','post',], 'fare/create', [FareController::class,'create']);
Route::match(['get','post',], 'fare/update', [FareController::class,'update']);
Route::match(['get','post',], 'fare/delete', [FareController::class,'delete']);

//Location
Route::match(['get','post',], 'location/list', [LocationController::class,'list']);
Route::match(['get','post',], 'location/items', [LocationController::class,'items']);
Route::match(['get','post',], 'location/create', [LocationController::class,'create']);
Route::match(['get','post',], 'location/update', [LocationController::class,'update']);
Route::match(['get','post',], 'location/delete', [LocationController::class,'delete']);

//Personnel
Route::match(['get','post',], 'personnel/list', [PersonnelController::class,'list']);
Route::match(['get','post',], 'personnel/items', [PersonnelController::class,'items']);
Route::match(['get','post',], 'personnel/create', [PersonnelController::class,'create']);
Route::match(['get','post',], 'personnel/update', [PersonnelController::class,'update']);
Route::match(['get','post',], 'personnel/delete', [PersonnelController::class,'delete']);
Route::match(['get','post',], 'personnel/update_profile', [PersonnelController::class,'update_profile']);
Route::match(['get','post',], 'personnel/update_password', [PersonnelController::class,'update_password']);

//PersonnelSchedule
Route::match(['get','post',], 'personnel_schedule/list', [PersonnelScheduleController::class,'list']);
Route::match(['get','post',], 'personnel_schedule/items', [PersonnelScheduleController::class,'items']);
Route::match(['get','post',], 'personnel_schedule/create', [PersonnelScheduleController::class,'create']);
Route::match(['get','post',], 'personnel_schedule/update', [PersonnelScheduleController::class,'update']);
Route::match(['get','post',], 'personnel_schedule/delete', [PersonnelScheduleController::class,'delete']);
Route::match(['get','post',], 'personnel_schedule/find', [PersonnelScheduleController::class,'find']);
Route::match(['get','post',], 'personnel_schedule/find1', [PersonnelScheduleController::class,'find1']);

//Position
Route::match(['get','post',], 'position/list', [PositionController::class,'list']);
Route::match(['get','post',], 'position/items', [PositionController::class,'items']);
Route::match(['get','post',], 'position/create', [PositionController::class,'create']);
Route::match(['get','post',], 'position/update', [PositionController::class,'update']);
Route::match(['get','post',], 'position/delete', [PositionController::class,'delete']);

//Reminder
Route::match(['get','post',], 'reminder/list', [ReminderController::class,'list']);
Route::match(['get','post',], 'reminder/items', [ReminderController::class,'items']);
Route::match(['get','post',], 'reminder/create', [ReminderController::class,'create']);
Route::match(['get','post',], 'reminder/update', [ReminderController::class,'update']);
Route::match(['get','post',], 'reminder/delete', [ReminderController::class,'delete']);

//Route
Route::match(['get','post',], 'route/list', [RouteController::class,'list']);
Route::match(['get','post',], 'route/items', [RouteController::class,'items']);
Route::match(['get','post',], 'route/create', [RouteController::class,'create']);
Route::match(['get','post',], 'route/update', [RouteController::class,'update']);
Route::match(['get','post',], 'route/delete', [RouteController::class,'delete']);
Route::match(['get','post',], 'route/check', [RouteController::class,'check']);

//Schedule
Route::match(['get','post',], 'schedule/list', [ScheduleController::class,'list']);
Route::match(['get','post',], 'schedule/items', [ScheduleController::class,'items']);
Route::match(['get','post',], 'schedule/create', [ScheduleController::class,'create']);
Route::match(['get','post',], 'schedule/update', [ScheduleController::class,'update']);
Route::match(['get','post',], 'schedule/delete', [ScheduleController::class,'delete']);
Route::match(['get','post',], 'schedule/s', [ScheduleController::class,'s']);

//Status
Route::match(['get','post',], 'status/list', [StatusController::class,'list']);
Route::match(['get','post',], 'status/items', [StatusController::class,'items']);
Route::match(['get','post',], 'status/create', [StatusController::class,'create']);
Route::match(['get','post',], 'status/update', [StatusController::class,'update']);
Route::match(['get','post',], 'status/delete', [StatusController::class,'delete']);

//Trip
Route::match(['get','post',], 'trip/list', [TripController::class,'list']);
Route::match(['get','post',], 'trip/items', [TripController::class,'items']);
Route::match(['get','post',], 'trip/create', [TripController::class,'create']);
Route::match(['get','post',], 'trip/update', [TripController::class,'update']);
Route::match(['get','post',], 'trip/delete', [TripController::class,'delete']);
Route::match(['get','post',], 'trip/departure', [MapsController::class,'departure']);

// Track
Route::match(['get','post',], 'track/track_position', [MapsController::class, 'track_position']);

//User
Route::match(['get','post',], 'user/list', [UserController::class,'list']);
Route::match(['get','post',], 'user/items', [UserController::class,'items']);
Route::match(['get','post',], 'user/create', [UserController::class,'create']);
Route::match(['get','post',], 'user/update', [UserController::class,'update']);
Route::match(['get','post',], 'user/delete', [UserController::class,'delete']);
