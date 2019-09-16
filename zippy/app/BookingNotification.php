<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingNotification extends Model {

	protected $fillable = ['title', 'message', 'booking_id', 'customer_id', 'vendor_id'];

}	