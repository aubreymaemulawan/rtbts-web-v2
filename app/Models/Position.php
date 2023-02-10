<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';
    protected $primaryKey = 'id';

    // A Position belongs to Bus
    public function bus(){
        return $this->belongsTo(Bus::class);
    }
}
