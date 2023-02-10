<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';

    // A Status belongs to Trip
    public function trip(){
        return $this->belongsTo(Trip::class);
    }
}
