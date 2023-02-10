<?php

namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\PersonnelSchedule;
use App\Models\Trip;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
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
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
