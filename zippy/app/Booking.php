<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    const PENDING = 1;
    const ACCEPT = 2;
    const CANCEL = 3;
    const PROCESS = 4;
    const PICKUP = 5;
    const IN_TRANSIT = 6;
    const PAYMENT = 7;
    const COMPLETE = 8;
    const ALLOCATION_PENDING = 9;
    const CONFIRMATION_PENDING = 10; // customer confirmation pending
    const VENDOR_CONFIRMATION_PENDING = 11; // vendor confirmation pending
    const EXPIRED = 12;
    // const CLOSE = 13;
    
    const TYPE_INTRA = 1;
    const TYPE_INTER = 2;

    protected $fillable = [
        'type',
        'customer_id',
        'vendor_id',
        'payment_type',
        'actual_booking_date',
        'pickup_date',
        'pickup_time',
        'pickup_datetime',
        'pickup_city_id',
        'drop_city_id',
        'pickup_address',
        'pickup_coordinates',
        'pickup_lat',
        'pickup_lng',
        'drop_address',
        'drop_coordinates',
        'drop_lat',
        'drop_lng',
        'total_distance',
        'total_amount',
        'customer_amount',
        'cargo_type_id',
        'vehicle_count',
        'vehicle_type_id',
        'gross_weight',
        'carton_lenght',
        'carton_breadth',
        'carton_height',
        'volume',
        'package_count',
        'vehicle_category_id',
        'freight_cost',
        'is_vendor_complete_status',
        'status',
        'no_of_vehicle',
        'actual_gross_weight',
        'volumetric_weight',
        'additional_info',

        // bill
        'drop_date',
        'drop_time',
        'content',
        'package',
        'consignor_gst',
        'consignee_gst',
        'air_way_bill',
        'eway_bill',
        'sender_signature',
        'is_insured',
        'paid_dkt_charges',
        'paid_freight',
        'paid_service_charges',
        'paid_fov',
        'paid_cod',
        'paid_misc',
        'fod_dkt_charges',
        'fod_freight',
        'fod_service_charges',
        'fod_fov',
        'fod_cod',
        'fod_misc',
        'paid_igst',
        'fod_igst',
        'invoice_no',
        'declared_value',
        'sender_sign',
        'consignee_name',
        'consignee_email',
        'consignee_mobile_no',
        'consignor_company',
        'consignee_company',
        'consignor_sign',
        'consignee_sign',
        'change_vehicle_driver',
        'customer_reason',
        'customer_sign',
        'cancelled_by_id',
        'contact_person',
        'contact_person_no',
        'bill_pickup_address',
        'bill_drop_address',
    ];

    public function pickupCityRel() {
        return $this->belongsTo(City::class, 'pickup_city_id');
    }

    public function dropCityRel(){
        return $this->belongsTo(City::class, 'drop_city_id');
    }

    public function paymentType() {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }

    public function setPickupCoordinatesAttribute($val) {
        if (!$val) return;
        $arr = explode(',', $val);
        if( isset($arr[0]) ) $this->attributes['pickup_lat'] = $arr[0];
        if( isset($arr[1]) ) $this->attributes['pickup_lng'] = $arr[1];
        return $this->attributes['pickup_coordinates'] = $val;
    }

    public function setDropCoordinatesAttribute($val) {
        if (!$val) return;
        $arr = explode(',', $val);
        if( isset($arr[0]) ) $this->attributes['drop_lat'] = $arr[0];
        if( isset($arr[1]) ) $this->attributes['drop_lng'] = $arr[1];
        return $this->attributes['drop_coordinates'] = $val;
    }

    public function setPickupDateAttribute($val) {
        $this->attributes['pickup_datetime'] = date('Y-m-d', strtotime(request('pickup_date'))). ' '. date('H:i:s', strtotime(request('pickup_time')));
        return $this->attributes['pickup_date'] = $val;
    }

    public function setActualBookingDateAttribute($val) {
        return $this->attributes['actual_booking_date'] = date('Y-m-d', strtotime($val));
    }

    public function getActualBookingDateAttribute() {

        if(! (isset($this->attributes['actual_booking_date']) && isset($this->attributes['created_at'])) ) return '';

        $date = $this->attributes['actual_booking_date'];

        if( in_array($date, ['0000-00-00', '0000-00-00 00:00:00']) || (!$date)) return getDateValue($this->attributes['created_at']);

        return getDateValue($this->attributes['actual_booking_date']);
    }

    public function getPaidFreightAttribute() {

        try {
            if( $this->attributes['payment_type'] == 2 ) {
                return $this->attributes['customer_amount'];
            } else {
                return 0;
            }            
        } catch (\Exception $e) {
            return 0;
        }

    }

    public function getFodFreightAttribute() {
        try {
            if( $this->attributes['payment_type'] == 3 ) {
                return $this->attributes['customer_amount'];
            } else {
                return 0;
            }            
        } catch (\Exception $e) {
            return 0;
        }

    }

    public function biddings() {
        return $this->hasMany(BookingBid::class);
    }

    // 'customer', 'vendor', 'driver', 'vehicle', 'status'
    public function customer() {
        return $this->belongsTo(User::class);
    }

    public function vendor() {
        return $this->belongsTo(User::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function cargo_type() {
        return $this->belongsTo(CargoType::class);
    }

    public function vehicle_type() {
        return $this->belongsTo(VehicleType::class);
    }

    public function vehicle_category() {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function booking_logs() {
        return $this->hasMany(BookingLog::class);
    }

    public function booking_status() {
        return $this->belongsTo(BookingStatus::class, 'status');
    }

    public static function checkBeforeBookingLiveStatus( $status ) {
        if( in_array($status, [\App\Booking::PENDING,\App\Booking::ACCEPT,\App\Booking::PROCESS,\App\Booking::PICKUP,\App\Booking::ALLOCATION_PENDING,\App\Booking::CONFIRMATION_PENDING,\App\Booking::VENDOR_CONFIRMATION_PENDING]) ) return true;
        return false;
    }

}
