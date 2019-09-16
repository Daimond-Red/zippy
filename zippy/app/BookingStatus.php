<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model {

    protected $table = 'booking_status';

    protected $fillable = [
        'title',
        'color_code',
    ];

}
