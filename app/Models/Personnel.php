<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = 'personnel';
    protected $primaryKey = 'id';

    // A Personnel belongs to Company
    public function company(){
        return $this->belongsTo(Company::class);
    }
    // INVERSE: A Personnel has one Account
    public function account(){
        return $this->hasOne(Account::class);
    }
    // INVERSE: A Personnel has many Personnel Schedule 
    public function personnel_schedule(){
        return $this->hasMany(PersonnelSchedule::class);
    }
    // INVERSE: A Personnel has one User
    public function user(){
        return $this->hasOne(User::class);
    }
    // INVERSE: A Personnel has many Trip
    public function trip(){
        return $this->hasMany(Trip::class);
    }
    // INVERSE: A Personnel has many View Message 
    public function view_message(){
        return $this->hasMany(ViewMessage::class);
    }
}
