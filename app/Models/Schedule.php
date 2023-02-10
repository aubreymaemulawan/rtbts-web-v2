<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'id';

    // A Schedule belongs to Company
    public function company(){
        return $this->belongsTo(Company::class);
    }
    // A Schedule belongs to Route
    public function route(){
        return $this->belongsTo(Route::class);
    }
    // INVERSE: A Schedule has many Personnel Schedule 
    public function personnel_schedule(){
        return $this->hasMany(PersonnelSchedule::class);
    }
}
