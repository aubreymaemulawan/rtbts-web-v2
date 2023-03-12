<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelRole extends Model
{
    protected $table = 'personnel_role';
    protected $primaryKey = 'id';

    // A Personnel Role belongs to Personnel
    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }
}
