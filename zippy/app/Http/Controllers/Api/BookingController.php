<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\AppNotificationRepository;
use App\Basecode\Classes\Repositories\PaymentTypeRepository;
use App\Booking;
use App\BookingBid;
use App\BookingLog;
use App\City;
use App\PaymentType;
use App\ReviewRating;
use App\User;
use App\UserNotification;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\Basecode\Classes\Repositories\CustomerRepository;
use App\Basecode\Classes\Repositories\VendorRepository;
use App\Basecode\Classes\Repositories\BookingStatusTrackerRepository;
use App\Basecode\Classes\Repositories\UserNotificationRepository;

class BookingController extends ApiController {

    public $bookingRepository, $customerRepository, $vendorRepository, $bookingStatusTrackerRepository, $userNotificationRepository, $paymentTypeRepository, $appNotificationRepository;

    public function __construct(
        BookingRepository $bookingRepository,
        CustomerRepository $customerRepository,
        VendorRepository $vendorRepository,
        BookingStatusTrackerRepository $bookingStatusTrackerRepository,
        UserNotificationRepository $userNotificationRepository,
        PaymentTypeRepository $paymentTypeRepository,
        AppNotificationRepository $appNotificationRepository
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->customerRepository = $customerRepository;
        $this->vendorRepository = $vendorRepository;
        $this->bookingStatusTrackerRepository = $bookingStatusTrackerRepository;
        $this->userNotificationRepository = $userNotificationRepository;
        $this->paymentTypeRepository = $paymentTypeRepository;
        $this->appNotificationRepository = $appNotificationRepository;
    }

    public function create() {

        $rules = [
            'type'                  => 'required|in:1,2',
            'customer_id'           => 'required|exists:users,id',
            // 'total_distance'        => 'required',
        ];


        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        if( \request('type') == 1 ) {

            $vendors = $this->bookingRepository->getRelatedVendors(request('vehicle_category_id'))->toArray();

            if(!$vendors) return $this->error([], 'No nearby vendors');

        }

        // NEW BOOKING RECORD
         
        // return $attrs;
        $booking = $this->bookingRepository->save($attrs = $this->bookingRepository->getAttrs());

        // BOOKING CUSTOMER
        $customer = $this->customerRepository->find(\request('customer_id'));

        // BASED ON VEHICLE TYPE, BASE AND DROP CITY WE WILL FILTER VENDORS
        $vendorIds = $this->vendorRepository->getBasedOnBaseNDropCity(\request('pickup_city_id'), \request('drop_city_id'), \request('vehicle_type_id'))->pluck('id');

        $msg = str_replace('{BOOKING_ID}', $booking->id, _t('vendor_push_40'));
        sendNotification($vendorIds->toArray(), [
            'booking_id'    => $booking->id,
            'category'      => 'create_booking',
            'body'          => $msg
        ]);

        $msg = str_replace('{BOOKING_ID}', $booking->id, _t('welcome_msg_client_39'));
        sendNotification($customer->id, [
            'booking_id'    => $booking->id,
            'category'      => 'create_booking',
            'body'          => $msg
        ]);

        return $this->data($this->bookingRepository->parseModel($booking), 'Booking created successfully.', 'booking');

    }

    public function accept() {

        $rules = [
            'vendor_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
            'driver_id'     => 'required',
            'vehicle_id'    => 'required',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->bookingRepository->find(request('booking_id'));

        if((Int)$model->change_vehicle_driver > 1) return $this->error([], 'You cannot change vehicle and driver.');

        // if(! in_array($model->status, [Booking::PENDING, Booking::ALLOCATION_PENDING]) ) return $this->error([], 'Vehicle and Driver changed and assigned succesfully for the trip.');

        $bookingLog = BookingLog::where('booking_id', request('booking_id'))->where('vendor_id', request('vendor_id'))->first();
        $bookingLog = BookingLog::where('booking_id', request('booking_id'))->where('vendor_id', request('vendor_id'))->get();

        $attrs = request()->all();
        $attrs['customer_id'] = $model->customer_id;


        $driver_ids = explode(',', \request('driver_id'));
        $vehicle_ids = explode(',', \request('vehicle_id'));
        
        if( count($driver_ids) != count($vehicle_ids) ) return $this->error([], 'Bad request');

        if(count($bookingLog) ) {
            if((Int)$model->change_vehicle_driver < 2) {
                foreach ($bookingLog as $bookingLogModel) {

                    foreach( $driver_ids as $index => $driver_id ) {

                        $bookingLogModel->driver_id = $driver_id;
                        $bookingLogModel->vehicle_id = $vehicle_ids[$index];

                        $bookingLogModel->update();
                    }
                }
            } else {
                return $this->error([], 'You have already accepted this booking.');
            }
            

        } else {

            foreach( $driver_ids as $index => $driver_id ) {

                $attrs['driver_id'] = $driver_id;
                $attrs['vehicle_id'] = $vehicle_ids[$index];

                $bookingLog = new BookingLog;
                $bookingLog->fill($attrs);
                $bookingLog->save();
            }
        }

        if( $model->status == Booking::ALLOCATION_PENDING ) {

            $bookingBid = BookingBid::where('booking_id', $model->id)->where('vendor_id', \request('vendor_id'))->first();

            if( $bookingBid ) {
                $bookingBid->status = BookingBid::CONFIRM;
                $bookingBid->save();
                // $model->total_amount = $bookingBid->amount;
            }

            $model->status = Booking::ACCEPT;

            $model->change_vehicle_driver = (Int)$model->change_vehicle_driver + 1;

            $model->save();

            // will get vehicles numbers
            $vehicleNos = Vehicle::whereIn('id', $vehicle_ids)->pluck('registration_no')->toArray();
            // will get drivers names
            $names = User::whereIn('id', $driver_ids)->pluck('first_name')->toArray();
            // will get drivers mobile nos
            $nos = User::whereIn('id', $driver_ids)->pluck('mobile_no')->toArray();

            $msg = str_replace('{VEHICLE_NO}', implode(',', $vehicleNos), _t('final_client_intimation_45'));
            $msg = str_replace('{DRIVER_NAME}', implode(',', $names), $msg);
            $msg = str_replace('{DRIVER_NO}', implode(',', $nos), $msg);

            $msg = str_replace('{BOOKING_ID}', $model->id, $msg);

            sendNotification($model->customer_id, [
                'booking_id'    => $model->id,
                'category'      => 'booking_accept',
                'body'          => $msg
            ]);
            // Term notification
            sendNotification($model->customer_id, [
                'booking_id'    => $model->id,
                'category'      => 'booking_term',
                'body'          => _t('zippys_terms_of_carriage_46')
            ]);

        } else {
            $model->change_vehicle_driver = (Int)$model->change_vehicle_driver + 1;
            $model->update();

            $msg = str_replace('{Booking_Id}', $model->id, _t('change_vehicle_driver_60'));
            
            sendNotification($model->customer_id, [
                'booking_id'    => $model->id,
                'category'      => 'vehicle_driver_change',
                'body'          => $msg
            ]);
        }

        return $this->data($this->bookingRepository->parseModel($model), 'Vehicle and driver assigned successfully.');

    }

    public function changeDriversNVehicles() {

        $rules = [
            'vendor_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
            'driver_id'     => 'required',
            'vehicle_id'    => 'required',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->bookingRepository->find(request('booking_id'));

        $driverIds = explode(',', \request('driver_id'));
        $vehicleIds = explode(',', \request('vehicle_id'));

        if( count($driverIds) != count($vehicleIds) ) return $this->error(['Driver and vehicle selection must be the same']);
        if( $model->no_of_vehicle != count($driverIds) ) return $this->error(['Invalid driver and vehicle selected']);

        $bookingLogs = BookingLog::where('booking_id', \request('booking_id'))->where('vendor_id', \request('vendor_id'))->get();

        foreach( $bookingLogs as $index => $log ) {

            $log->driver_id = $driverIds[$index];
            $log->vehicle_id = $vehicleIds[$index];
            $log->save();

        }

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('misc_change_of_vehicle_48'));

        // will get vehicles numbers
        $vehicleNos = Vehicle::whereIn('id', $vehicleIds)->pluck('registration_no')->toArray();
        // will get drivers names
        $names = User::whereIn('id', $driverIds)->pluck('first_name')->toArray();
        // will get drivers mobile nos
        $nos = User::whereIn('id', $driverIds)->pluck('mobile_no')->toArray();

        $msg = str_replace('{VEHICLE_NO}', implode(',', $vehicleNos), $msg);
        $msg = str_replace('{DRIVER_NAME}', implode(',', $names), $msg);
        $msg = str_replace('{DRIVER_NO}', implode(',', $nos), $msg);

        sendNotification($model->customer_id, [
            'booking_id'    => $model->id,
            'category'      => 'changeDriversNVehicles',
            'body'          => $msg
        ]);

        return $this->data(['changed successfully']);

    }

    public function biddingStore() {

        $rules = [
            'vendor_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
            'amount'        => 'required'
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->bookingRepository->find(request('booking_id'));

        if($model->status != 1) return $this->error([], 'This booking cannot be accepted ');

        $bookingLog = BookingBid::where('booking_id', request('booking_id'))->where('vendor_id', request('vendor_id'))->first();
        if($bookingLog) return $this->error([], 'You have already provided your bid on this booking');

        $attrs = \request()->all();
        $attrs['customer_id'] = $model->customer_id;

        $bookingBid = new BookingBid;
        $bookingBid->fill($attrs);
        $bookingBid->save();

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('vendor_quote_confirmation_41'));

        sendNotification(request('vendor_id'), [
            'booking_id'    => $model->id,
            'category'      => 'biddingStore',
            'body'          => $msg
        ]);

        return $this->emptyData([], $msg);

    }

    /**
     * customer_id IS REQUIRED TO GET
     * CUSTOMER BOOKING HISTORY
     */
    public function customer_my_history() {

        if($err = $this->cvalidate([ 'customer_id' => 'required|exists:users,id' ])) return $this->error($err, $err->first());

        if(!$model = $this->customerRepository->find(request('customer_id'))) return $this->error([], 'Invalid details');

        $bookings = $this->bookingRepository->getCollection()->whereCustomerId($model->id)->whereNotIn('status', [Booking::COMPLETE, Booking::EXPIRED])->get();

        if ( $bookings && !count($bookings)) return ['error' => false, 'data' => [ 'history' => [] ], 'message' => '' ];

        return $this->data($this->bookingRepository->parseCollection($bookings), '', 'history');

    }

    public function customer_completed_history() {

        if($err = $this->cvalidate([ 'customer_id' => 'required|exists:users,id' ])) return $this->error($err, $err->first());

        if(!$model = $this->customerRepository->find(request('customer_id'))) return $this->error([], 'Invalid details');

        $bookings = $this->bookingRepository->getCollection()->whereCustomerId($model->id)->where('status', Booking::COMPLETE)->orderBy('id', 'desc')->get();

        if ( $bookings && !count($bookings)) return ['error' => false, 'data' => [ 'history' => [] ], 'message' => '' ];

        return $this->data($this->bookingRepository->parseCollection($bookings), '', 'history');

    }

    
    /**
     * vendor_id IS REQUIRED TO GET
     * VENDOR BOOKING HISTORY
     */
    public function vendor_my_history() {

        if($err = $this->cvalidate([ 'vendor_id' => 'required|exists:users,id' ])) return $this->error($err, $err->first());

        if(!$model = $this->vendorRepository->find(request('vendor_id'))) return $this->error([], 'Invalid details');

        $bookings = $this->bookingRepository
                        ->getCollection(false)
                        ->whereVendorId($model->id)
                        ->whereNotIn('status', [Booking::COMPLETE, Booking::CONFIRMATION_PENDING, Booking::ALLOCATION_PENDING, Booking::CANCEL, Booking::VENDOR_CONFIRMATION_PENDING, Booking::EXPIRED])
                        ->orderBy('id', 'desc')->get();

        return $this->data($this->bookingRepository->parseCollection($bookings));

    }

    public function vendorCompletedHistory() {

        if($err = $this->cvalidate([ 'vendor_id' => 'required|exists:users,id' ])) return $this->error($err, $err->first());

        if(!$model = $this->vendorRepository->find(request('vendor_id'))) return $this->error([], 'Invalid details');

        $bookings = $this->bookingRepository
            ->getCollection(false)
            ->whereVendorId($model->id)
            ->whereIn('status', [Booking::COMPLETE, BOOKING::CANCEL])
            ->orderBy('id', 'desc')->get();

        return $this->data($this->bookingRepository->parseCollection($bookings));

    }

    public function vendor_bidding_history() {

        if($err = $this->cvalidate([
            'vendor_id' => 'required|exists:users,id'
        ])) return $this->error($err, $err->first());

        if(!$model = $this->vendorRepository->find(request('vendor_id'))) return $this->error([], 'Invalid details');

        $areas = $this->vendorRepository->parseServiceableAreas($model->serviceableArea()->get(), true);

        if(!$areas) return $this->data([]);

        $bookingIds = [];

        foreach ( $areas as $area ) {
            $baseCityIds = City::where('state_id', $area['base_state_id'])->pluck('id');
            $dropCityIds = City::whereIn('state_id', $area['drop_state_id'])->pluck('id');
            $ids = $this->bookingRepository
                            ->getModel()
                            ->whereIn('pickup_city_id', $baseCityIds)
                            ->whereIn('drop_city_id', $dropCityIds)
                            ->pluck('id')
                            ->toArray();

            $bookingIds = array_unique(array_merge($ids, $bookingIds));
        }

        $alreadyBiddingIds = BookingBid::where('vendor_id', \request('vendor_id'))->pluck('booking_id');

        $bookings = $this->bookingRepository->getModel()
                        ->whereIn('id', $bookingIds)
                        ->whereNotIn('id', $alreadyBiddingIds)
                        ->whereType(Booking::TYPE_INTER)
                        ->where('status', Booking::PENDING)
                        ->whereVendorId(0)
                        ->whereIn('vehicle_type_id', $model->vehicles->pluck('vehicle_type_id'))
                        ->whereDate('pickup_date', '>=', date('Y-m-d'))
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return $this->data($this->bookingRepository->parseCollection($bookings));

    }

    /**
     * vendor_id and booking_id IS REQUIRED IN THIS API
     * VENDOR WILL HIT THIS API TO CANCEL BOOKING STATUS
     * ONLY PENDING BOOKING STATUS IS ALLOWED TO CHANGE BOOKING STATUS
     */
    public function vendorCancel() {

        $rules = [
            'vendor_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        if(!$vendor = $this->vendorRepository->find(request('vendor_id'))) return $this->error('Invalid detail');

        $booking = $this->bookingRepository->find(request('booking_id'));
        if($booking->status != 1) return $this->error([], 'You are not allowed to update this booking');

        $booking = $this->bookingStatusTrackerRepository->save(['booking_id' => $booking->id, 'user_id' => request('vendor_id'), 'status' => 3]);

        return $this->data([], 'Booking changed to mark cancel');

    }


    /**
     * user_id and booking_id IS REQUIRED IN THIS API
     * USER/VENDOR WILL HIT THIS API TO CHANGE BOOKING STATUS
     * PENDING = 1; ACCEPT = 2; CANCEL = 3; PROCESS = 4; PICKUP = 5; IN_TRANSIT = 6; PAYMENT = 7; COMPLETE = 8;
     */
    public function updateStatus() {

        $rules = [
            'user_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
            'status'    =>  'required|in:3,4,5,6,7,8'
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $booking = $this->bookingRepository->find(request('booking_id'));

        if(request('booking_id') == 3 && $booking->status > 3) return $this->error([], 'You cannot cancel this booking');

        $attrs['status'] = request('status');

        if($val = \request('customer_sign')) $attrs['customer_sign'] = $val;

        $booking = $this->bookingRepository->update($booking, $attrs);

        
        $msg = '';

        if( \request('status') == Booking::PROCESS ) {
            $msg = 'You booking ID:'.$booking->id.' been updated to processing';
        } elseif( \request('status') == Booking::PICKUP ) {
            $msg = 'You booking ID:'.$booking->id.' been updated to pickup';
        } elseif( \request('status') == Booking::IN_TRANSIT ) {
            $msg = 'You booking ID:'.$booking->id.' is in transit now as the trip has started from origin.';
        } elseif( \request('status') == Booking::PAYMENT ) {
            $msg = 'You booking ID:'.$booking->id.' been updated to payment';
        } elseif( \request('status') == Booking::COMPLETE ) {
            $msg = 'Your booking ID:'.$booking->id.' is completed now as the goods have been delivered at the destination.';
        }

        try {
            sendNotification($booking->customer_id, [
                'booking_id' => $booking->id,
                'category' => 'booking_status_change',
                'body' => $msg
            ]);    
        } catch (\Exception $e) {
            
        }
        
        return $this->data($this->bookingRepository->parseModel($booking), 'Booking status changed successfully', 'booking_details');

    }

    /**
     * partner_id IS REQUIRED TO GET
     * VENDOR BOOKING Request
     */
    public function vendor_customer_request() {

        if($err = $this->cvalidate([ 'partner_id' => 'required|exists:users,id' ])) return $this->error($err, $err->first());

        $vendorVehicles = $this->bookingRepository->getRelatedVehicleBookings(request('partner_id'));
        $vendorCancel = $this->bookingRepository->getRelatedCancelVendor(request('partner_id'));
        $vendorAccept = $this->bookingRepository->getRelatedAcceptVendor(request('partner_id'));
        $exceptBooking = array_unique(array_merge($vendorCancel,$vendorAccept));

        $bookings = $this->bookingRepository->getCollection()->whereIn('vehicle_category_id', $vendorVehicles)->whereNotIn('id', $exceptBooking)->where('status', 1)->get();

        if(!$bookings) return $this->error([], 'No nearby booking');

        return $this->data($this->bookingRepository->parseCollection($bookings), '', 'booking_request');

    }

    /**
     * vendor_id and booking_id IS REQUIRED IN THIS API
     * WE WILL UPDATE is_vendor_complete_status KEY TO TRUE
     * AND CREATE NEW RATING ENTRY.
     */
    public function rating_by_vendor() {

        $rules = [
            'vendor_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
            'rating'        => 'required|in:1,2,3,4,5'
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        if(!$vendor = $this->vendorRepository->find(request('vendor_id'))) return $this->error('Invalid detail');

        $booking = $this->bookingRepository->find(request('booking_id'));

        // if($booking->status != 8) return $this->error([], 'You are not allowed to give rating');

        if( $vendor->id != $booking->vendor_id ) return $this->error([], 'You are not allowed to give rating.');

        // will return error if vendor already review this booking
        if( $booking->is_vendor_complete_status ) return $this->error([], 'You are not allowed to give review.');

        $booking = $this->bookingRepository->update($booking, ['is_vendor_complete_status' => true]);

        $rating = new ReviewRating;

        $rating->fill([
            'booking_id'    => request('booking_id'),
            'rated_by_id'   => request('vendor_id'),
            'rating'        => request('rating'),
            'review'        => request('review', ''),
            'type'          => User::VENDOR,
            'rated_id'      => $booking->customer_id,
        ]);

        $rating->save();



        return $this->data([], 'Thanks for submitting your rating and reviews');

    }

    public function rating_by_customer() {

        $rules = [
            'customer_id'   => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
            'rating'        => 'required|in:1,2,3,4,5'
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        if(!$customer = $this->customerRepository->find(request('customer_id'))) return $this->error([], 'Invalid detail');

        $booking = $this->bookingRepository->find(request('booking_id'));

        if( $customer->id != $booking->customer_id ) return $this->error([], 'You are not allowed to give the rating');

        // if($booking->status != 8) return $this->error([], 'You are not allowed to give rating');

        $booking = $this->bookingRepository->update($booking, ['status' => 8]);

        $rating = new ReviewRating;

        $rating->fill([
            'booking_id'    => request('booking_id'),
            'rated_by_id'   => request('customer_id'),
            'rating'        => request('rating'),
            'review'        => request('review', ''),
            'type'          => User::CUSTOMER,
            'rated_id'      => $booking->vendor_id,
        ]);

        $rating->save();

        return $this->data([], 'Thanks for submitting your rating and reviews');

    }

     /**
     * user_id IS REQUIRED IN THIS API
     */
    public function userNotification() {

        $rules = [
            'user_id'   => 'required|exists:users,id',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $user = User::findOrFail(\request('user_id'));

        return $this->data($this->appNotificationRepository->parseCollection($user->appNotifications()->orderBy('id', 'desc')->get()));

    }

    public function paymentTypes() {    

        // dd(PaymentType::get()->toArray());
        return $this->data( $this->paymentTypeRepository->parseCollection(PaymentType::get()) );

    }

    public function vendorGetPendingRatingBookings() {

        $rules = [
            'vendor_id'   => 'required|exists:users,id',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $collection = $this->bookingRepository
                            ->getCollection()
                            ->where('vendor_id', \request('vendor_id'))
                            ->where('is_vendor_complete_status', 0)
                            ->where('status', Booking::COMPLETE)
                            ->get();

        return $this->data($this->bookingRepository->parseCollection($collection));

    }


    public function vendorMarkConfirm() {

        $rules = [
            'vendor_id'     => 'required|exists:users,id',
            'booking_id'    => 'required|exists:bookings,id',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->bookingRepository->find(\request('booking_id'));

        if( ($model->vendor_id != \request('vendor_id')) || ($model->status != Booking::VENDOR_CONFIRMATION_PENDING)) return $this->error([], 'Completion mark is not allowed');

        $model->status = Booking::CONFIRMATION_PENDING;
        $model->save();

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('client_quote_42'));
        $msg = str_replace('{AMOUNT}', $model->customer_amount, $msg);

        sendNotification($model->customer_id, [
            'booking_id'    => $model->id,
            'category'      => 'vendor_assign',
            'body'          => $msg
        ]);

        return $this->data([], 'Thanks for the confirmation');

    }


    public function getDetails() {

        $rules = ['booking_id'    => 'required|exists:bookings,id' ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->bookingRepository->find(\request('booking_id'));

        return $this->data($this->bookingRepository->parseModel($model));

    }

    public function updateDetails() {

        $rules = ['booking_id'    => 'required|exists:bookings,id' ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->bookingRepository->find(\request('booking_id'));
        
        $fields = [
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
            'invoice_no',
            'declared_value',
            'sender_sign',
            'consignee_name',
            'consignee_email',
            'consignee_mobile_no',
        ];

        foreach ( $fields as $field ) {
            if( $val = request($field) ) $model->$field = $val;
        }

        $model->save();

        return $this->data($this->bookingRepository->parseModel($model), 'Updated successfully');

    }



}