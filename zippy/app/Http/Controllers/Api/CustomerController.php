<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\BookingRepository;
use App\Booking;
use App\CargoType;
use App\PaymentType;
use App\User;
use App\VehicleCategory;
use App\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Password;
use App\BookingBid;

class CustomerController extends ApiController {

    public $customerRepository, $bookingRepository;

    public function __construct( CustomerRepository $customerRepository, BookingRepository $bookingRepository ) {
        $this->customerRepository = $customerRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function register() {

        $attrs = request()->all();

        $rules = [
            'customer_type'     => 'required|in:1,2',
            'signup_type'       => 'required|in:facebook,gplus,normal',
            'first_name'        => 'required|max:255|min:2',
            'last_name'         => 'required|max:255|min:2',
            'email'             => 'required|max:255|email',
            'mobile_no'         => 'required|digits:10|numeric',
            'password'          => 'required|max:500|min:4',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        if( $attrs['signup_type'] == 'facebook' ) {

            if($err = $this->cvalidate(['facebook_id' => 'required'])) return $this->error($err, $err->first());

            $model = $this->customerRepository->getModel()->where(function($q){
                $q->orWhere('email', request('email'))->orWhere('mobile_no', request('mobile_no'))->orWhere('facebook_id', request('facebook_id'));
            })->first();

            if( $model ) $this->customerRepository->update($model, request()->only(['signup_type', 'facebook_id']));

        } elseif( $attrs['signup_type'] == 'gplus' ) {

            if($err = $this->cvalidate(['gplus_id' => 'required'])) return $this->error($err, $err->first());

            $model = $this->customerRepository->getModel()->where(function($q){
                $q->orWhere('email', request('email'))->orWhere('mobile_no', request('mobile_no'))->orWhere('gplus_id', request('gplus_id'));
            })->first();

            if( $model ) $this->customerRepository->update($model, request()->only(['signup_type', 'gplus_id']));

        } else {

            $model = $this->customerRepository->getModel()->whereEmail(request('email'))->first();
            // if($model) return $this->error([], 'The email you entered already exists');

            if(! $model ) $model = $this->customerRepository->getModel()->whereMobileNo(request('mobile_no'))->first();
            // if($model) return $this->error([], 'The mobile no. you entered already exists');

        }

        if(! $model ) $model = $this->customerRepository->save($this->customerRepository->getAttrs());

        if( $model->role != User::CUSTOMER ) return $this->error([], 'Either email or mobile no you entered already exists with our vendor app');

        if(! $model->status ) $this->customerRepository->update($model, [ 'otp' => sendOtp($model->mobile_no), 'otp_created_at' => date('Y-m-d H:i:s') ]);

        return $this->data($this->customerRepository->parseModel($model), 'Account created successfully', 'customer_details');

	}

    public function verifyOtp() {

        $attrs = request()->all();

        if ( $error = $this->cvalidate( ['mobile_no' => 'required', 'otp' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->customerRepository->getCollection()->where('mobile_no', request('mobile_no'))->first();

        if(!$model) return $this->error([], 'This mobile number is not registered with us');

        $to_time = strtotime( date('Y-m-d H:i:s') );
        $from_time = strtotime( $model->otp_created_at );
        $diff = round(abs($to_time - $from_time) / 60,0);

        if(! ($attrs['otp'] == '1111' && config('app.debug')) ) {
            // otp will be expired after 5 minutes
            if( $diff > 5 ) return $this->error([], 'OTP expired');

            // both otp should be same
            if( $attrs['otp'] != $model->otp ) return $this->error([], 'Invalid OTP');

        }


        if(! $model->status ) {

            try {

                \Mail::send( 'emails.signup', request()->all(), function($message) use ($model) {
                    $message
                        ->to( $model->email, implode(' ', [$model->first_name, $model->last_name]))
                        ->bcc( getNAddMailAddress(), $model->firstname)
                        ->subject('Zippy: Welcome Mail');
                });

            } catch ( \Exception $e ) {

            }

        }

        // this will enable model.
        $model->status = '1';
        $model->otp = '';
        $model->otp_created_at = null;
        $model->save();

        return $this->data($this->customerRepository->parseModel($model), 'OTP has been verified successfully', 'customer_details');

    }

    public function resentOtp() {

        $attrs = request()->all();

        if ( $error = $this->cvalidate( ['mobile_no' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->customerRepository->getCollection()->where('mobile_no', request('mobile_no'))->first();

        if(!$model) return $this->error([], 'Invalid account details');

        $model = $this->customerRepository->update($model, [ 'otp' => sendOtp($model->mobile_no), 'otp_created_at' => date('Y-m-d H:i:s') ]);

        return $this->data($this->customerRepository->parseModel($model), 'OTP has been sent to your mobile number', 'customer_details');

    }

	public function login() {

        $rules = [
            'password'      => 'required',
            // 'device_id'     => 'required',
            // 'device_type'   => 'required|in:android,ios',
            // 'device_token'  => 'required',
            'login_type'    => 'required|in:mobile,email',
        ];
        $field = '';
        if(request('login_type') == 'email'){ $rules['email'] = 'required|email';$field = 'email'; }
        if(request('login_type') == 'mobile'){ $rules['mobile_no'] = 'required|digits:10|numeric';$field = 'mobile_no'; }

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        if(! auth()->attempt([$field => request($field), 'password' => request('password'), 'role' => \App\User::CUSTOMER]) ) return $this->error([], 'The login details you entered is incorrect');

        if(!auth()->user()->status) return $this->error([], 'your account is not verified yet');

        if(!auth()->user()->is_enable) return $this->error([], 'Your are not allowed to login.');

        $model = $this->customerRepository->find(auth()->user()->id);

        if(request('device_id')) $model = $this->customerRepository->update($model, request()->only('device_id', 'device_type', 'device_token'));

        return $this->data($this->customerRepository->parseModel($model), 'You are successfully logged in', 'customer_details');

	}

	public function forgetPassword() {
        // return request('email');
        $user = $this->customerRepository->getCollection()->whereEmail(request('email'))->first();

        if(!$user) return $this->error([], 'Invalid account details');


        try{

            $response = Password::broker()->sendResetLink(
                request()->only('email')
            );

        } catch (\Exception $e){
//                echo $e->getMessage(); die;
            return $this->error([], 'We are unable to send email to your email address.');
        }

        return $this->data($this->customerRepository->parseModel($user), 'An email has been sent to given email id', 'customer_details');

	}

    public function signout() {

        $rules = [ 'customer_id' => 'required|exists:users,id' ];
        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->customerRepository->find(request('customer_id'));

        $this->customerRepository->update($model, ['device_id' => '', 'device_type' => '', 'device_token' => '']);

        return $this->data([], 'Logged out successfully', 'customer_details');

    }

    public function updateProfile() {

        $rules = [ 'customer_id' => 'required|exists:users,id' ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->customerRepository->find(request('customer_id'));

        if(!$model->status) return $this->error([], 'your account is not verified yet');
        // return $this->customerRepository->getAttrs();
        $model = $this->customerRepository->update($model, $this->customerRepository->getAttrs());

        return $this->data($this->customerRepository->parseModel($model), '', 'customer_details');
        
    }

    public function typeOfCargos() {
        $collection = CargoType::select('id as cargo_type_id', 'title')->get(['cargo_type_id', 'title']);
        return $this->data($collection, '', 'type_of_cargos');
    }

    public function typeOfVehicleRequired() {
        $collection = VehicleType::select('id as vehicle_type_id', 'title', 'payload')->get(['vehicle_type_id', 'title', 'payload']);
        return $this->data($collection, '', 'type_of_vehicle_required');
    }

    public function vehicleCategories() {
        $collection = VehicleCategory::select('id as vehicle_category_id', 'title', 'image')->get(['vehicle_category_id', 'title', 'image']);
        return $this->data($collection, '', 'vehicle_categories');
    }

    public function suggestedVehicles() {
        $collection = VehicleCategory::get();
        return $this->data($collection, '', 'suggested_vehicles');
    }

    public function chooseVehicles() {
        $collection = VehicleCategory::get();
        return $this->data($collection, '', 'choose_vehicles');
    }

    public function getProfile() {

        $rules = [ 'email' => 'required|exists:users,email' ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->customerRepository->getCollection()->whereEmail(request('email'))->first();

        if(!$model) return $this->error([], 'Invalid email');

        return $this->data($this->customerRepository->parseModel($model));

    }

    public function markBookingCancel() {

        $rules = [
            'customer_id'   => 'required',
            'booking_id'    => 'required|exists:bookings,id',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $this->customerRepository->find(\request('customer_id'));

        $booking = $this->bookingRepository->find(\request('booking_id'));

        if( $booking->customer_id != \request('customer_id') ) return $this->error([], 'Invalid Data');

        if( $booking->status == Booking::CANCEL ) return $this->error([], 'You have already cancelled the order');

        // only pending bookings are allowed for cancellation.
        if(! Booking::checkBeforeBookingLiveStatus($booking->status) ) return $this->error([], 'Booking cannot be cancelled');

        $this->bookingRepository->update($booking, [
            'status' => Booking::CANCEL, 
            'customer_reason' => \request('customer_reason'),
            'cancelled_by_id' => request('customer_id'),
        ]);

        $vendorIds = BookingBid::where('booking_id', $booking->id)
            ->whereIn('status', [Booking::PENDING, BookingBid::PENDING, Booking::ALLOCATION_PENDING, Booking::CONFIRMATION_PENDING, Booking::VENDOR_CONFIRMATION_PENDING, BookingBid::CLOSE])
            ->pluck('vendor_id')->toArray();

        //if($booking->vendor_id) {
            
            // $msg = str_replace('{ BOOKING ID}', $booking->id, _t('booking_cancellation_vendor_56'));

            $msg = str_replace('{BOOKING_ID}', $booking->id, _t('booking_cancel_by_client_63'));

            sendNotification($vendorIds, [
                'booking_id'    => $booking->id,
                'category'      => 'booking_cancel',
                'body'          => $msg
            ]);

        // }
        

        return $this->data([], 'Booking has been cancelled');

    }

    public function markConfirmBooking() {

        $rules = [
            'customer_id'       => 'required',
            'booking_id'        => 'required|exists:bookings,id',
            'contact_person'    => 'required',
            'contact_person_no' => 'required',
            'consignor_sign'    => 'required'
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $this->customerRepository->find(\request('customer_id'));

        $booking = $this->bookingRepository->find(\request('booking_id'));

        if( $booking->customer_id != \request('customer_id') || ($booking->status != Booking::CONFIRMATION_PENDING)) return $this->error([], 'Invalid Data');

        $this->bookingRepository->update($booking, [
            'status'            => Booking::ALLOCATION_PENDING, 
            'pickup_address'    => request('pickup_address'),
            'drop_address'      => request('drop_address'),
            'total_distance'    => request('total_distance'),
            'additional_info'   => request('additional_info'),
            'contact_person'    => request('contact_person'),
            'contact_person_no' => request('contact_person_no'),
            'consignor_sign'    => request('consignor_sign')
        ]);

        $msg = str_replace('{BOOKING_ID}', $booking->id, _t('order_confirmation_push_43'));

        $paymentType = PaymentType::find($booking->payment_type);

        if($paymentType) {
            $paymentType = $paymentType->title;
            $msg = str_replace('{PAYMENT}', $paymentType, $msg);
        }



        sendNotification($booking->customer_id, [
            'booking_id'    => $booking->id,
            'category'      => 'mark_confirm',
            'body'          => $msg
        ]);
        // $msg = str_replace('{BOOKING_ID}', $booking->id, _t('vendor_assignment_push_44'));
        $msg = str_replace('{BOOKING_ID}', $booking->id, _t('vendor_order_confirmation_67'));
        sendNotification($booking->vendor_id, [
            'booking_id'    => $booking->id,
            'category'      => 'mark_confirm',
            'body'          => $msg
        ]);

        $this->bookingRepository->createBookingLog($booking->id, $booking->customer_id, User::CUSTOMER, Booking::ALLOCATION_PENDING);

        return $this->data([], 'Thank you for confirming your booking. We shall allocate the Vehicle/ Driver soon against your booking(s).');

    }

    public function getOpenOrder() {

        $rules = [ 'customer_id'   => 'required' ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $collection = $this->bookingRepository
                    ->getCollection()
                    ->where('customer_id', \request('customer_id'))
                    ->whereNotIn('status', [Booking::COMPLETE, Booking::EXPIRED, Booking::CANCEL])
                    ->orderBy('updated_at', 'desc')
                    ->get();

        return $this->data( $this->bookingRepository->parseCollection($collection) );

    }

}