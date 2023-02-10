<?php
use App\Models\PersonnelSchedule;
use App\Models\Trip;
use App\Models\Position;

    $trip_today = Trip::where('arrived',0)->whereDate('created_at', '=', date('Y-m-d'))->get();
    $speed = 0;
    $distance = 0;
    $orig_lat = 0;
    $orig_lng = 0;
    $dest_lat = 0;
    $dest_lng = 0;
    $latFrom = 0;
    $lonFrom = 0;
    $latTo = 0;
    $latTo = 0;
    $angle = 0;
    foreach($trip_today as $tr){
        $bus_id = $tr->personnel_schedule->bus_id;
        $position = Position::where('bus_id',$bus_id)->latest('created_at')->first();
        if($tr->inverse == 0){
            $orig_lat = $tr->personnel_schedule->schedule->route->orig_latitude;
            $orig_lng = $tr->personnel_schedule->schedule->route->orig_longitude;
            $dest_lat = $tr->personnel_schedule->schedule->route->dest_latitude;
            $dest_lng = $tr->personnel_schedule->schedule->route->dest_longitude;
        }else{
            $dest_lat = $tr->personnel_schedule->schedule->route->orig_latitude;
            $dest_lng = $tr->personnel_schedule->schedule->route->orig_longitude;
            $orig_lat = $tr->personnel_schedule->schedule->route->dest_latitude;
            $orig_lng = $tr->personnel_schedule->schedule->route->dest_longitude;
        }

        if($position){
            $orig_lat = $position->latitude;
            $orig_lng = $position->longitude;
        }
        
        $earthRadius = 6371000;
        $latFrom = deg2rad($orig_lat);
        $lonFrom = deg2rad($orig_lng);
        $latTo = deg2rad($dest_lat);
        $lonTo = deg2rad($dest_lng);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $distance = $angle * $earthRadius;
        
        if($tr->distance == $distance){
        }else{
            Trip::where([['arrived',0],['id',$tr->id]])->update([
                'distance' => $distance 
            ]);
        }

        if($tr->distance <= 1000){
            Trip::where([['arrived',0],['id',$tr->id]])->update([
                'arrived' => 1 // Arrived
            ]);
        }
?>