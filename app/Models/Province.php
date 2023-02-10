<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'ph_province';
    protected $primaryKey = 'id';

    // INVERSE: A Province has many City
    public function city(){
        return $this->hasMany(City::class);
    }
}
