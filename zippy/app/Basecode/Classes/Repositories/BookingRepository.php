<?php

namespace App\Basecode\Classes\Repositories;

use App\Booking;
use App\BookingBid;
use App\BookingStatusTracker;
use App\City;
use App\User;
use App\VehicleCategory;
use App\BookingLog;

class BookingRepository extends Repository {

    public $vehicleRepository,
        $vendorRepository,
        $customerRepository,
        $driverRepository,
        $cargoTypeRepository,
        $vehicleTypeRepository,
        $vehicleCategoryRepository,
        $bookingStatusRepository,
        $bookingStatusTrackerRepository,
        $paymentTypeRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        VendorRepository $vendorRepository,
        DriverRepository $driverRepository,
        VehicleRepository $vehicleRepository,
        CargoTypeRepository $cargoTypeRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        VehicleCategoryRepository $vehicleCategoryRepository,
        BookingStatusRepository $bookingStatusRepository,
        BookingStatusTrackerRepository $bookingStatusTrackerRepository,
        PaymentTypeRepository $paymentTypeRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->vendorRepository = $vendorRepository;
        $this->customerRepository = $customerRepository;
        $this->driverRepository = $driverRepository;
        $this->cargoTypeRepository = $cargoTypeRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->bookingStatusRepository = $bookingStatusRepository;
        $this->bookingStatusTrackerRepository = $bookingStatusTrackerRepository;
        $this->paymentTypeRepository = $paymentTypeRepository;
    }

    public $model = '\App\Booking';

    public $viewIndex = 'admin.bookings.index';
    public $viewCreate = 'admin.bookings.create';
    public $viewEdit = 'admin.bookings.edit';
    public $viewShow = 'admin.bookings.show';

    public $storeValidateRules = [
        'title' => 'required'
    ];

    public $updateValidateRules = [];

    public function getRelatedVendors($vehicleCategoryId) {
        $vendor_ids = $this->vehicleRepository->getCollection()->where('vehicle_category_id', $vehicleCategoryId)->pluck('vendor_id');
        return $this->vendorRepository->getCollection()->whereIn('id', $vendor_ids)->get();
    }

    public function getRelatedVehicleBookings($vendorId) {
        return $this->vehicleRepository->getCollection()->where('vendor_id', $vendorId)->distinct()->pluck('vehicle_category_id')->toArray();
    }

    public function getRelatedCancelVendor($vendorId) {
        return $this->bookingStatusTrackerRepository->getCollection()->where('user_id', $vendorId)->where('status', 3)->pluck('booking_id')->toArray();
    }

    public function getRelatedAcceptVendor($vendorId) {
        return BookingLog::where('vendor_id', $vendorId)->pluck('booking_id')->toArray();
    }

    public function getAttrs() {
        $attrs = parent::getAttrs();

        $attrs['no_of_vehicle'] = 1;
        
        if( request('type') == 1 ) {
            $vehicleCategory = VehicleCategory::find($attrs['vehicle_category_id']);
            $attrs['total_amount'] = ($vehicleCategory->price * $attrs['total_distance']) + request('freight_cost');
        }

        return $attrs;
    }

    public function getCollection( $withFilters = true ) {
        $model = new $this->model;

        $model = $model->with([
            'customer',
            'vendor',
            'driver',
            'vehicle',
            'cargo_type',
            'vehicle_type',
            'vehicle_category',
        ])->orderBy('updated_at', 'desc');

        if( $withFilters ) {

            $whereLikefields = ['customer_id', 'vendor_id', 'status' ];

            foreach ($whereLikefields as $field) {
                if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
            }

            if($value = request('start')) $model = $model->whereDate('created_at', '>=', $value);
            if($value = request('end'))   $model = $model->whereDate('created_at', '<=', $value);
            if( $value = request('status') ) $model = $model->whereStatus($value);

        }


        return $model;
    }

    public function getVendorLogIds($booking_id) {
        $model = $this->find($booking_id);
        $vendor_ids = [];
        foreach( $model->booking_logs as $log) $vendor_ids[] = $log->vendor_id;
        return $vendor_ids;
    }

    /**
     * THIS FUNCTION ACCEPT BOOKING ID
     * AND RETURN VENDOR COLLECTION LIST
     * THAT HAS APPLIED FOR THIS BOOKING
     */
    public function getVendorLogCollection($booking_id) {
        $vendor_ids = $this->getVendorLogIds($booking_id);
        return $this->vendorRepository->getCollection()->whereIn('id', $vendor_ids)->get();
    }

    public function parseModel($model) {

        $arr = [];
        $arr['booking_id']                  = (string)$this->prepare_field('id', $model);
        $arr['customer_id']                 = (string)$this->prepare_field('customer_id', $model);
//        $arr['driver_id']                   = (string)$this->prepare_field('driver_id', $model);
//        $arr['vehicle_id']                  = (string)$this->prepare_field('vehicle_id', $model);
        $arr['vendor_id']                   = (string)$this->prepare_field('vendor_id', $model);
        $arr['actual_booking_date']         = (string)$this->prepare_field('actual_booking_date', $model);
        $arr['pickup_date']                 = (string)$this->prepare_field('pickup_date', $model);
        $arr['pickup_time']                 = (string)$this->prepare_field('pickup_time', $model);
        $arr['pickup_address']              = (string)$this->prepare_field('pickup_address', $model);
        $arr['pickup_coordinates']          = (string)$this->prepare_field('pickup_coordinates', $model);
        $arr['drop_address']                = (string)$this->prepare_field('drop_address', $model);
        $arr['drop_coordinates']            = (string)$this->prepare_field('drop_coordinates', $model);

        $arr['pickup_city_name']            = (string) City::getCitiesNames($model->pickup_city_id);
        $arr['drop_city_name']              = (string) City::getCitiesNames($model->drop_city_id);

        $arr['total_distance']              = (string)$this->prepare_field('total_distance', $model);
        $arr['total_amount']                = (string)$this->prepare_field('total_amount', $model);
        $arr['customer_amount']             = (string)$this->prepare_field('customer_amount', $model);
        $arr['cargo_type_id']               = (string)$this->prepare_field('cargo_type_id', $model);
        $arr['vehicle_type_id']             = (string)$this->prepare_field('vehicle_type_id', $model);
        $arr['gross_weight']                = (string)$this->prepare_field('gross_weight', $model);
        $arr['carton_lenght']               = (string)$this->prepare_field('carton_lenght', $model);
        $arr['carton_breadth']              = (string)$this->prepare_field('carton_breadth', $model);
        $arr['carton_height']               = (string)$this->prepare_field('carton_height', $model);
        $arr['volume']                      = (string)$this->prepare_field('volume', $model);
        $arr['vehicle_category_id']         = (string)$this->prepare_field('vehicle_category_id', $model);
        $arr['freight_cost']                = (string)$this->prepare_field('freight_cost', $model);
        $arr['is_vendor_complete_status']   = (string)$this->prepare_field('is_vendor_complete_status', $model);
        $arr['status']                      = (string)$this->prepare_field('status', $model);

        if( $model->status == Booking::CANCEL ) {
            $arr['status_text']             = (string)getBookingStatusText($model);
        } else {
            $arr['status_text']             = (string)$this->getStatusText($model->status);
        }
        

        $arr['drop_date']                   = (string)$this->prepare_field('drop_date', $model);
        $arr['drop_time']                   = (string)$this->prepare_field('drop_time', $model);
        $arr['content']                     = (string)$this->prepare_field('content', $model);
        $arr['package']                     = (string)$this->prepare_field('package', $model);
        $arr['consignor_gst']               = (string)$this->prepare_field('consignor_gst', $model);
        $arr['consignee_gst']               = (string)$this->prepare_field('consignee_gst', $model);
        $arr['air_way_bill']                = (string)$this->prepare_field('id', $model);
        $arr['eway_bill']                   = (string)$this->prepare_field('eway_bill', $model);
        $arr['sender_signature']            = (string)$this->prepare_field('sender_signature', $model);
        $arr['is_insured']                  = (string)$this->prepare_field('is_insured', $model);
        $arr['paid_dkt_charges']            = (string)$this->prepare_field('paid_dkt_charges', $model);

        if( $model->payment_type == 2 ) {
            $arr['paid_freight']                = (string)$this->prepare_field('customer_amount', $model);
            $arr['fod_freight']                 = '0';
        } else {
            $arr['paid_freight']                = '0';
            $arr['fod_freight']                 = (string)$this->prepare_field('customer_amount', $model);    
        }

        
        
        $arr['paid_service_charges']        = (string)$this->prepare_field('paid_service_charges', $model);
        $arr['paid_fov']                    = (string)$this->prepare_field('paid_fov', $model);
        $arr['paid_cod']                    = (string)$this->prepare_field('paid_cod', $model);
        $arr['paid_misc']                   = (string)$this->prepare_field('paid_misc', $model);
        $arr['fod_dkt_charges']             = (string)$this->prepare_field('fod_dkt_charges', $model);
        $arr['fod_service_charges']         = (string)$this->prepare_field('fod_service_charges', $model);
        $arr['fod_fov']                     = (string)$this->prepare_field('fod_fov', $model);
        $arr['fod_cod']                     = (string)$this->prepare_field('fod_cod', $model);
        $arr['fod_misc']                    = (string)$this->prepare_field('fod_misc', $model);
        $arr['paid_igst']                   = (string)$this->prepare_field('paid_igst', $model);
        $arr['fod_igst']                    = (string)$this->prepare_field('fod_igst', $model);
        $arr['invoice_no']                  = (string)$this->prepare_field('invoice_no', $model);
        $arr['declared_value']              = (string)$this->prepare_field('declared_value', $model);
        $arr['sender_sign']                 = (string)$this->prepare_field('sender_sign', $model);

        $arr['consignee_name']              = (string)$this->prepare_field('consignee_name', $model);
        $arr['consignee_email']             = (string)$this->prepare_field('consignee_email', $model);
        $arr['consignee_mobile_no']         = (string)$this->prepare_field('consignee_mobile_no', $model);

        $arr['paid_subtotal']               =  $model->paid_dkt_charges + $model->paid_freight + $model->paid_service_charges + $model->paid_fov + $model->paid_cod + $model->paid_misc;
        $arr['fod_subtotal']                =  $model->fod_dkt_charges + $model->fod_freight + $model->fod_service_charges + $model->fod_fov + $model->fod_cod + $model->fod_misc;
        $arr['grand_total']                 = $arr['paid_subtotal'] + $arr['fod_subtotal'];

        $arr['created_at']                  = (string)$this->prepare_field('created_at', $model);
        $arr['updated_at']                  = (string)$this->prepare_field('updated_at', $model);

        $arr['type']                        = (string)$this->prepare_field('type', $model);
        $arr['no_of_vehicle']               = (string)$this->prepare_field('no_of_vehicle', $model);
        $arr['actual_gross_weight']         = (string)$this->prepare_field('actual_gross_weight', $model);
        $arr['volumetric_weight']           = (string)$this->prepare_field('volumetric_weight', $model);
        $arr['additional_info']             = (string)$this->prepare_field('additional_info', $model);
        $arr['customer_sign']               = (string)$this->prepare_field('customer_sign', $model);
        
        $arr['customer'] = new \stdClass();
        $arr['vendor'] = new \stdClass();
//        $arr['drivers'] = new \stdClass();
//        $arr['vehicles'] = new \stdClass();
        $arr['cargo_type'] = new \stdClass();
        $arr['payment_type'] = new \stdClass();
        $arr['vehicle_type'] = new \stdClass();
        $arr['vehicle_category'] = new \stdClass();
        $arr['booking_status'] = new \stdClass();

        if( isset($model->customer) && $model->customer ) {

            $arr['customer'] = $this->customerRepository->parseModel($model->customer);

            if ( request('vendor_id') && ($model->status != Booking::CANCEL) && ($model->vendor_id != request('vendor_id')) ) {
                $arr['customer']['first_name'] = '';
                $arr['customer']['last_name'] = '';
                $arr['customer']['email'] = '';
                $arr['customer']['mobile_no'] = '';
            }

        }

        if( isset($model->vendor) && $model->vendor ) $arr['vendor'] = $this->vendorRepository->parseModel($model->vendor);
        if( isset($model->paymentType) && $model->paymentType ) $arr['payment_type'] = $this->paymentTypeRepository->parseModel($model->paymentType);

        $driverIds = BookingLog::where('booking_id', $model->id)->pluck('driver_id');
        $drivers = $this->driverRepository->getCollection()->whereIn('id', $driverIds)->get();
        $arr['drivers'] = $this->driverRepository->parseCollection($drivers);

        $vehicleIds = BookingLog::where('booking_id', $model->id)->pluck('vehicle_id');
        $vehicles = $this->vehicleRepository->getCollection()->whereIn('id', $vehicleIds)->get();
        $arr['vehicles'] = $this->vehicleRepository->parseCollection($vehicles);

        if( isset($model->cargo_type) && $model->cargo_type ) $arr['cargo_type'] = $this->cargoTypeRepository->parseModel($model->cargo_type);
        if( isset($model->vehicle_type) && $model->vehicle_type ) $arr['vehicle_type'] = $this->vehicleTypeRepository->parseModel($model->vehicle_type);
        if( isset($model->vehicle_category) && $model->vehicle_category ) $arr['vehicle_category'] = $this->vehicleCategoryRepository->parseModel($model->vehicle_category);
        if( isset($model->status) && $model->status) $arr['booking_status'] = $this->bookingStatusRepository->parseModel($model->booking_status);

        $arr['booking_expired'] = false;
        if( $model->status == Booking::CONFIRMATION_PENDING && $model->pickup_date < date('Y-m-d') ) $arr['booking_expired'] = true;

        $arr['contact_person'] = (string) $model->contact_person;
        $arr['contact_person_no'] = (string) $model->contact_person_no;

        return $arr;

    }

    public function whereLocationDistance($orig_lat, $orig_lon, $distanceInMiles = 50) {

        return Booking::select('*', \DB::raw(" round( 3956 * 2 * ASIN(SQRT( POWER(SIN(($orig_lat - abs( pickup_lat)) * pi()/180 / 2),2) + COS($orig_lat * pi()/180 ) * COS( abs (pickup_lat) *  pi()/180) * POWER(SIN(($orig_lon - pickup_lng) *  pi()/180 / 2), 2) )), 1) as gDistance"))
            //->having('gDistance', '<=', $distanceInMiles)
            ;

    }

    public function getStatusText($status) {

        if( $status == \App\Booking::PENDING ) {
            return 'Request Submitted';
        } elseif( $status == \App\Booking::ACCEPT ) {
            return 'Vehicle Assigned';
        } elseif( $status == \App\Booking::CANCEL ) {
            return 'Cancelled';
        } elseif( $status == \App\Booking::PROCESS ) {
            return 'Processing';
        } elseif( $status == \App\Booking::PICKUP ) {
            return 'Pickup';
        } elseif( $status == \App\Booking::IN_TRANSIT ) {
            return 'In Transit';
        } elseif( $status == \App\Booking::PAYMENT ) {
            return 'Payment';
        } elseif( $status == \App\Booking::COMPLETE ) {
            return 'Complete';
        } elseif( $status == \App\Booking::ALLOCATION_PENDING ) {
            return 'Veh Allocation Pending';     
        } elseif( $status == \App\Booking::CONFIRMATION_PENDING ) {
            return 'Confirmation Pending';
        } elseif( $status == \App\Booking::VENDOR_CONFIRMATION_PENDING) {
            return 'Vendor Confirmation Pending';
        } elseif( $status == \App\Booking::EXPIRED) {
            return 'Expired';
        } else {
            return '';
        }

    }

    public function getVendorWhoNotBidOnBooking($id) {

        $vendorIds = BookingBid::where('booking_id', $id)->pluck('vendor_id')->toArray();

        return $this->vendorRepository->getCollection(false)->whereNotIn('id', $vendorIds);

    }

    public function createBookingLog($bookingId, $userId, $userType, $status){

        $model = new BookingStatusTracker;

        $model->booking_id = $bookingId;
        $model->user_id = $userId;
        $model->user_type = $userType;
        $model->status = $status;
        $model->save();

    }

    public function save( $attrs ) {

        $attrs = $this->getValueArray($attrs);

        $model = new $this->model;
        $model->fill($attrs);
        $model->save();

        $this->createBookingLog($model->id, $model->customer_id, User::CUSTOMER, Booking::PENDING);

        return $model;
    }

}