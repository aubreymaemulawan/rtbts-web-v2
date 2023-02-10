<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $primaryKey = 'id';

    // An Account belongs to Personnel
    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }
}
