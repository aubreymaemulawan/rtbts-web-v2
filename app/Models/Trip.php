<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trip';
    protected $primaryKey = 'id';

    // A Trip belongs to Schedule
    public function personnel_schedule(){
        return $this->belongsTo(PersonnelSchedule::class);
    }
    // INVERSE: A Trip has many Status
    public function status(){
        return $this->hasMany(Status::class);
    }
    // A Trip belongs to Personnel
    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }
}
