<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingLog extends Model {

    protected $fillable = [
        'customer_id',
        'booking_id',
        'vendor_id',
        'driver_id',
        'vehicle_id',
        'status_id',
    ];

    public function vendor() {
        return $this->belongsTo(User::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }


}
