<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserNotification extends Authenticatable
{
    use Notifiable;

    const NO_PARTNER_REQUEST = 'You have received new request';
    const NO_ADMIN_ASSIGN = 'Admin assign you new request';
    const NO_PARTNER_PROCESS = 'Booking status change into process';
    const NO_ADMIN_PICKUP = 'Booking status change into pickup';
    const NO_ADMIN_INTRANSIT = 'Booking status change into in transit';
    const NO_ADMIN_PAYMENT = 'Booking status change into in waiting for payment';
    const NO_ADMIN_COMPLETE = 'Booking status change into in complete';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'message',
        'seen',
    ];



    public function users() {
        return $this->belongsTo('App\User');
    }

}
