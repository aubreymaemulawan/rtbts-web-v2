<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $table = 'bus';
    protected $primaryKey = 'id';

    // A Bus belongs to Company
    public function company(){
        return $this->belongsTo(Company::class);
    }
    // INVERSE: A Bus has many Position
    public function position(){
        return $this->hasMany(Position::class);
    }
    // INVERSE: A Bus has many Personnel Schedule 
    public function personnel_schedule(){
        return $this->hasMany(PersonnelSchedule::class);
    }
}
