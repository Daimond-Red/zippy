<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const SUPERADMIN = 1;
    const ADMIN = 2;
    const VENDOR = 3;
    const DRIVER = 4;
    const CUSTOMER = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile_no',
        'other_mobile',
        'image',
        'image_type',
        'facebook_id',
        'gplus_id',
        'signup_type',
        'locations',
        'pancard_no',
        'aadhar_no',
        'company_name',
        'business_type',
        'gstin',
        'device_id',
        'device_type',
        'device_token',
        'customer_type',
        'otp',
        'otp_created_at',
        'status',
        //
        'vendor_id',
        'licence_no',
        'licence_pic',
        'dl_valid_upto',
        'address1',
        'address2',
        'city',
        'pincode',
        'state',
        'is_enable',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function drivers() {
        return $this->hasMany(User::class, 'vendor_id', 'id');
    }

    public function vehicles() {
        return $this->hasMany(Vehicle::class, 'vendor_id', 'id');
    }

    public function areas() {
        return $this->belongsToMany(Area::class);
    }

    public function serviceableArea() {
        return $this->hasMany(ServiceableArea::class);
    }

    public function getFullName() {
        return implode(' ', [$this->first_name, $this->last_name]);
    }

    public function appNotifications() {
        return $this->belongsToMany(AppNotification::class);
    }
    public function driverNotifications() {
        return $this->belongsToMany(DriverNotification::class);
    }

    public function vendor() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

}
