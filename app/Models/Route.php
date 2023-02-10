<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'route';
    protected $primaryKey = 'id';

    // A Route belongs to Company
    public function company(){
        return $this->belongsTo(Company::class);
    }
    // INVERSE: A Route has many Fare
    public function fare(){
        return $this->hasMany(Fare::class);
    }
    // INVERSE: A Route has many Schedule
    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}
