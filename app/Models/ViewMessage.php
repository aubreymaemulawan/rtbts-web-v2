<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewMessage extends Model
{
    protected $table = 'view_message';
    protected $primaryKey = 'id';

    // A View Message belongs to Personnel
    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }
    // A View Message belongs to Reminder
    public function reminder(){
        return $this->belongsTo(Reminder::class);
    }
}
