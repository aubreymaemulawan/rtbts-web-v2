<?php
use App\Models\PersonnelSchedule;
use App\Models\Trip;
use App\Models\Position;
use App\Models\Status;

    /////
    $trip_today = Trip::where('arrived',0)->whereDate('created_at', '=', date('Y-m-d'))->get();
    $speed = 0;
    $distance = 0;
    $orig_lat = 0;
    $orig_lng = 0;
    $dest_lat = 0;
    $dest_lng = 0;
    $lat = 0;
    $lng = 0;
    $angle = 0;
    $cntt = 0;
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

        if (($orig_lat == $dest_lat) && ($orig_lng == $dest_lng)) {
            $distance = 0;
        }else {
            $theta = $orig_lng - $dest_lng;
            $dist = sin(deg2rad($orig_lat)) * sin(deg2rad($dest_lat)) +  cos(deg2rad($orig_lat)) * cos(deg2rad($dest_lat)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $distance = $miles * 1.609344;
        }
        
        if($tr->distance == $distance){
        }else{
            Trip::where([['arrived',0],['id',$tr->id]])->update([
                'distance' => $distance 
            ]);
        }

        if($distance <= 0.5){
            $created_at = $tr->created_at;
            $updated_at = now();
            $to_time = strtotime($created_at);
            $from_time = strtotime($updated_at);
            $minutes = round(abs($to_time - $from_time) / 60,2);
            Trip::where([['arrived',0],['id',$tr->id]])->update([
                'arrived' => 1, // Arrived
                'trip_duration' => $minutes,
                'updated_at' => $updated_at,
            ]);
            $avail = Status::where('trip_id',$tr->id)->get();
            foreach($avail as $av){
                if($av->bus_status == 5){
                    $cntt++;
                }
            }
            if($cntt == 0){
                $latitude = Position::where('bus_id', $bus_id)->latest('created_at')->value('latitude');
                $longitude = Position::where('bus_id', $bus_id)->latest('created_at')->value('longitude');
                if($latitude && $longitude){
                    $lat = $latitude;
                    $lng = $longitude;
                }else{
                    $lat = 0;
                    $lng = 0;
                }
                $data = new Status(); // Create New Status
                $data->trip_id = $tr->id;
                $data->bus_status = 5;
                $data->latitude = $lat;
                $data->longitude = $lng;
                $data->save();
            }
        }
    }
?>