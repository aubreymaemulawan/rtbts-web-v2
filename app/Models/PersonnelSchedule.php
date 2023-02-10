<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelSchedule extends Model
{
    protected $table = 'personnel_schedule';
    protected $primaryKey = 'id';

    // A Personnel Schedule belongs to a Schedule
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    // A Personnel Schedule belongs to a Bus
    public function bus(){
        return $this->belongsTo(Bus::class);
    }
    // A Personnel Schedule belongs to a Personnel
    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }
    // INVERSE: A Schedule has many Trip
    public function trip(){
        return $this->hasMany(Trip::class);
    }
}
