<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'ph_city';
    protected $primaryKey = 'id';

    // A City belongs to Province
    public function province(){
        return $this->belongsTo(Province::class);
    }
}
