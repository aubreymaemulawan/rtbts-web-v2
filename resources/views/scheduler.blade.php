<?php

use App\Models\PersonnelSchedule;
use App\Models\Trip;


    PersonnelSchedule::whereDate('date', '<', date('Y-m-d'))->update([
        'status' => 3 // Done
    ]);
    $trip = Trip::with('personnel_schedule')->get();
    foreach($trip as $tr){
        if($tr->personnel_schedule->date < date('Y-m-d')){
            Trip::where([['arrived','!=',2],['id',$tr->id]])->update([
                'arrived' => 1 // Arrived
            ]);
        }
    }
?>
