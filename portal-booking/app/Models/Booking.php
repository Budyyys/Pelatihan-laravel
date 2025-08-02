<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'room_id',
        'title',
        'start_time',
        'end_time'
    ];
}
