<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingStatusTracker extends Model {


    protected $fillable = [
        'booking_id',
        'user_id',
        'status',
    ];

}
