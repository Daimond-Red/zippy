<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingBid extends Model {

    const PENDING = 0;
    const CONFIRM = 1;
    const CLOSE   = 3;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'vendor_id',
        'amount',
        'status',
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function vendor() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
