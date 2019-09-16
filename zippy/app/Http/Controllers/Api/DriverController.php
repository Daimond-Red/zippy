<?php

namespace App\Http\Controllers\Api;

use App\Basecode\Classes\Repositories\BookingRepository;
use App\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\DriverRepository;

class DriverController extends ApiController {

    public $repository, $bookingRepository;

    public function __construct(
        DriverRepository $repository,
        BookingRepository $bookingRepository

    ) {
        $this->repository = $repository;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        if ( $error = $this->cvalidate(['vendor_id' => 'required|exists:users,id']) ) return $this->error($error, $error->first());
        $collection = $this->repository->getCollection()->where('vendor_id', request('vendor_id'))->get();

        return $this->data($this->repository->parseCollection($collection), '', 'driver_details');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {

        if ( $error = $this->cvalidate($this->repository->storeValidateRules) ) return $this->error($error, $error->first());

        $model = $this->repository->save($this->repository->getAttrs());

        return $this->data($this->repository->parseModel($model), 'Thank you for adding a new driver.', 'driver_details');

    }


    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update() {

        $rules =  [
            'vendor_id' => 'required',
            'driver_id' => 'required|exists:users,id',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->find(request('driver_id'));

        $model = $this->repository->update($model);

        return $this->data($this->repository->parseModel($model), 'Driver information has been updated', 'driver_details');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy() {

        $rules =  [
            'vendor_id' => 'required',
            'driver_id' => 'required|exists:users,id',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->find(request('driver_id'));

        $this->repository->delete($model);

        return $this->data([], 'Driver removed', 'driver_details');

    }

    public function generatePassword() {

        $rules =  [
            'vendor_id' => 'required',
            'driver_id' => 'required|exists:users,id',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->find(request('driver_id'));
        $model->password = bcrypt('123456');
        $model->save();

        return $this->data([], 'Password Reset', 'driver_generate_password');

    }

    public function login() {

        $rules =  [
            'mobile_no' => 'required|exists:users,mobile_no',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = \App\User::where('mobile_no', \request('mobile_no'))->where('role', \App\User::DRIVER)->first();

        if(! $model ) return $this->error([], 'Invalid login details');

        $this->repository->update($model, [
            'otp' => sendOtp($model->mobile_no),
            'otp_created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->data([], 'An OTP has been send to your Mobile No.', 'driver_login');

    }

    public function otpVerify() {

        $attrs = request()->all();

        if ( $error = $this->cvalidate( ['mobile_no' => 'required', 'otp' => 'required'] ) ) return $this->error($error, 'Validation failed');

        $model = $this->repository->getCollection()->where('mobile_no', request('mobile_no'))->first();

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

        // this will enable model.
        $model->otp = '';
        $model->otp_created_at = null;
        $model->save();

        return $this->data($this->repository->parseModel($model), 'OTP verified successfully', 'driver_otp_verify');

    }

    public function reSendOtp() {

        $attrs = request()->all();

        if ( $error = $this->cvalidate( ['mobile_no' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->repository->getCollection()->where('mobile_no', request('mobile_no'))->first();

        if(!$model) return $this->error([], 'Invalid account details');

        $model = $this->repository->update($model, [ 'otp' => sendOtp($model->mobile_no), 'otp_created_at' => date('Y-m-d H:i:s') ]);

        return $this->data([], 'OTP has been sent to your mobile number', 'driver_otp_resend');

    }

    public function logout() {

        if ( $error = $this->cvalidate( ['mobile_no' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->repository->getCollection()->where('mobile_no', request('mobile_no'))->first();

        if(!$model) return $this->error([], 'Invalid account details');

        $this->repository->update($model, ['device_id' => '', 'device_type' => '', 'device_token' => '']);

        return $this->data([], 'Logout successfully');

    }

    public function openTripHistory() {

        if ( $error = $this->cvalidate( ['driver_id' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->repository->find(\request('driver_id'));

        if(!$model) return $this->error([], 'Invalid account details');

        $bookingIds = \App\BookingLog::where('driver_id', $model->id)->pluck('booking_id');

        $collection = $this->bookingRepository->getCollection()
                        ->whereIn('id', $bookingIds)
                        ->whereIn('status', [Booking::IN_TRANSIT, Booking::ACCEPT])->get();


        return response()->json (['error' => false, 'data' => [ 'results' => $this->bookingRepository->parseCollection($collection) ], 'message' => "" ]);
    }

    public function completedTripHistory() {

        if ( $error = $this->cvalidate( ['driver_id' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->repository->find(\request('driver_id'));

        if(!$model) return $this->error([], 'Invalid account details');

        $bookingIds = \App\BookingLog::where('driver_id', $model->id)->pluck('booking_id');

        $collection = $this->bookingRepository->getCollection()->whereIn('id', $bookingIds)->where('status', Booking::COMPLETE)->get();

        return response()->json (['error' => false, 'data' => [ 'results' => $this->bookingRepository->parseCollection($collection) ], 'message' => "" ]);

    }

    public function updateProfile() {

        if ( $error = $this->cvalidate( ['driver_id' => 'required'] ) ) return $this->error($error, 'Validation fails');

        $model = $this->repository->find(\request('driver_id'));

        if(!$model) return $this->error([], 'Invalid account details');

        $attrs = [
            'first_name',
            'last_name',
            'image',
            'licence_no',
            'licence_pic',
            'aadhar_no',
            'address1',
            'address2',
            'city',
            'state',
            'pincode',
        ];

        foreach ( $attrs as $field ) {
            if( \request($field) ) $model->$field = \request($field);
        }

        $model->save();

        return $this->data($this->repository->parseModel($model), 'driverUpdateProfile');

    }

    public function notificationList() {

        if ( $error = $this->cvalidate( ['driver_id' => 'required'] ) ) return $this->error($error, 'Validation failed');

        $model = $this->repository->getModel()->with('driverNotifications')->find(\request('driver_id'));
        
        if(!$model) return $this->error([], 'Invalid account details');
        
        if(!$model->driverNotifications) return $this->data([], '', 'driverNotificationList');
        
        $collection = [];
        foreach ( $model->driverNotifications as $num ) {
            $collection[] = ['notification_id' => $num->id, 'title' => 'title '.$num->title, 'content' => 'test content'. $num->message];
        }

        return $this->data($collection, '', 'driverNotificationList');
    }

}
