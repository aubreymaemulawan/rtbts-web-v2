<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    protected $table = 'fare';
    protected $primaryKey = 'id';

    // A Fare belongs to a Route
    public function route(){
        return $this->belongsTo(Route::class);
    }
}
