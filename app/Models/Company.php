<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';

    // INVERSE: A Company has many Bus
    public function bus(){
        return $this->hasMany(Bus::class);
    }
    // INVERSE: A Company has many Personnel
    public function personnel(){
        return $this->hasMany(Personnel::class);
    }
    // INVERSE: A Company has many Route
    public function route(){
        return $this->hasMany(Route::class);
    }
    // INVERSE: A Company has many Schedule
    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
    // INVERSE: A Company has many Reminder
    public function reminder(){
        return $this->hasMany(Reminder::class);
    }
}
