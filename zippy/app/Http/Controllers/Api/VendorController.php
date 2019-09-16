<?php

namespace App\Http\Controllers\Api;

use App\Area;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\Basecode\Classes\Repositories\CustomerRepository;
use App\Basecode\Classes\Repositories\DriverRepository;
use App\Booking;
use App\BookingBid;
use App\ServiceableArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VendorRepository;
use Illuminate\Support\Facades\Password;

class VendorController extends ApiController {

    public $vendorRepository, $bookingRepository, $customerRepository, $driverRepository;

    public function __construct(
        VendorRepository $vendorRepository,
        BookingRepository $bookingRepository,
        CustomerRepository $customerRepository,
        DriverRepository $driverRepository
    ) {
        $this->vendorRepository = $vendorRepository;
        $this->bookingRepository = $bookingRepository;
        $this->customerRepository = $customerRepository;
        $this->driverRepository = $driverRepository;
    }

    public function register() {

        $rules = [
            'first_name'        => 'required|max:255|min:2',
            'last_name'         => 'required|max:255|min:2',
            'email'             => 'required|max:255|email',
            'mobile_no'         => 'required|digits:10|numeric',
            'password'          => 'required|max:500|min:4',
        ];

        if($err = $this->cvalidate($rules)) return $this->error($err, $err->first());

        $model = $this->vendorRepository->getModel()->whereEmail(request('email'))->first();
        if($model) return $this->error([], 'The email you entered already exists');

        $model = $this->vendorRepository->getModel()->whereMobileNo(request('mobile_no'))->first();
        if($model) return $this->error([], 'The mobile no. you entered already exists');

        $model = $this->vendorRepository->save($this->vendorRepository->getAttrs());

        return $this->data($this->vendorRepository->parseModel($model), 'Thank you for joining Zippy. Please wait while we verify your details and activate your account', 'vendor_details');

    }

    public function login() {

        $rules = [
            'password'      => 'required',
            'device_id'     => 'required',
            'device_type'   => 'required|in:android,ios',
            'device_token'  => 'required',
            'login_type'    => 'required|in:mobile,email',
            'user_type'     => 'required'
        ];

        $field = '';

        if(request('login_type') == 'email'){ $rules['email'] = 'required|email';$field = 'email'; }

        if(request('login_type') == 'mobile'){ $rules['mobile_no'] = 'required|digits:10|numeric';$field = 'mobile_no'; }

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        if( \request('user_type') == 1 ) {

            if(! auth()->attempt([$field => request($field), 'password' => request('password'), 'role' => \App\User::VENDOR]) ) return $this->error([], 'The '.$field.' or password you entered is incorrect');

            if(!auth()->user()->status) return $this->error([], 'Your account is still being verified by us. Please wait for some more time');

            if(!auth()->user()->is_enable) return $this->error([], 'Your are not allowed to login.');

            $model = $this->vendorRepository->find(auth()->user()->id);
            $model = $this->vendorRepository->update($model, request()->only('device_id', 'device_type', 'device_token'));
            $model = $this->vendorRepository->parseModel($model);
        } else {
            if(! auth()->attempt([$field => request($field), 'password' => request('password'), 'role' => \App\User::DRIVER]) ) return $this->error([], 'The email or password you entered is incorrect');

            if(!auth()->user()->is_enable) return $this->error([], 'Your account is not allowed to login.');

            $model = $this->driverRepository->find(auth()->user()->id);
            $model = $this->driverRepository->update($model, request()->only('device_id', 'device_type', 'device_token'));
            $model = $this->driverRepository->parseModel($model);
        }
        
        return $this->data($model, 'You have logged in successfully', 'vendor_details');

    }

    public function forgetPassword() {

        $user = $this->vendorRepository->getCollection()->whereEmail(request('email'))->first();

        if(!$user) return $this->error([], 'Invalid account details');

        try{

            $response = Password::broker()->sendResetLink(
                request()->only('email')
            );

        } catch (Exception $e){
//                echo $e->getMessage(); die;
            return $this->error([], 'We are unable to send email to your email address.');
        }

        return $this->data($this->vendorRepository->parseModel($user), 'An email has been sent to given email id', 'vendor_details');

    }

    public function signout() {

        $rules = [ 'vendor_id' => 'required|exists:users,id' ];
        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->vendorRepository->find(request('vendor_id'));

        $this->vendorRepository->update($model, ['device_id' => '', 'device_type' => '', 'device_token' => '']);

        return $this->data([], 'Logged out successfully', 'vendor_details');

    }

    public function updateProfile() {

        $rules = [ 'vendor_id' => 'required|exists:users,id' ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        if($val = \request('email')) {
            $user = $this->vendorRepository->getModel()->where('email', $val)->where('id', '<>', \request('vendor_id'))->first();

            if($user) return $this->error([], 'This mail id already taken.');
        }

        if($val = \request('mobile_no')) {
            $user = $this->vendorRepository->getModel()->where('mobile_no', $val)->where('id', '<>', \request('vendor_id'))->first();

            if($user) return $this->error([], 'This mobile number already exists.');
        }

        $model = $this->vendorRepository->find(request('vendor_id'));

        $model = $this->vendorRepository->update($model, $this->vendorRepository->getAttrs());

        return $this->data($this->vendorRepository->parseModel($model), '', 'vendor_details');

    }

    public function getAreas() {
        $collection = Area::select('id as area_id', 'name', 'zipcode')->orderBy('created_at', 'desc')->get(['area_id', 'name', 'zipcode']);
        return $this->data($collection, '', 'get_areas');
    }

    public function pendingBidding() {

        $rules = [ 'vendor_id' => 'required|exists:users,id' ];
        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $collection = BookingBid::
                where('vendor_id', request('vendor_id'))
                ->whereIn('status', [Booking::PENDING, BookingBid::PENDING, Booking::ALLOCATION_PENDING, Booking::CONFIRMATION_PENDING, Booking::VENDOR_CONFIRMATION_PENDING, BookingBid::CLOSE])
                ->orderBy('id', 'desc')
                ->get();

        $data = [];

        foreach( $collection as $model ) {

            if( $model->booking && in_array($model->booking->status, [
                Booking::PENDING,
                Booking::ACCEPT,
                Booking::CANCEL,
                Booking::EXPIRED,
                BookingBid::PENDING,
                BookingBid::CLOSE,
                Booking::ALLOCATION_PENDING,
                Booking::CONFIRMATION_PENDING,
                Booking::VENDOR_CONFIRMATION_PENDING
            ]) ) {
                $arr = [
                    'booking'   => $this->bookingRepository->parseModel($model->booking),
                    'amount'    => $model->amount,
                    'closed'    => $model->status
                ];

                $data[] = $arr;
            }

        }

        return $this->data($data, '', 'pending_bidding');

    }

    public function confirmBidding() {

        $rules = [ 'vendor_id' => 'required|exists:users,id' ];
        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $collection = BookingBid::where('vendor_id', request('vendor_id'))->where('status', BookingBid::CONFIRM)->get();

        $data = [];

        foreach( $collection as $model ) {

            $arr = [
                'booking'   => $this->bookingRepository->parseModel($model->booking),
                'amount'    => $model->amount
            ];

            $data[] = $arr;
        }

        return $this->data($data, '', 'confirm_bidding');

    }

    // THIS FUNCTION WE ARE USING TO UPDATE SERVICEABLE AREA
    // BASED ON BASE CITY ID AND DROP CITY IDS
    public function serviceableAreas() {

        $rules = [ 'vendor_id' => 'required|exists:users,id', 'base_state_id' => 'required', 'drop_state_ids' => 'required' ];
        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $this->vendorRepository->updateServiceableAreas( \request('vendor_id'), \request('base_state_id'), explode(',', \request('drop_state_ids')) );

        return $this->data([], 'Areas updated');

    }

    public function deleteServiceableAreas() {

        $rules = [ 'vendor_id' => 'required|exists:users,id', 'base_state_id' => 'required' ];
        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        ServiceableArea::where('user_id', \request('vendor_id'))->where('base_state_id', \request('base_state_id'))->delete();

        return $this->data([], 'Area Removed');

    }

    public function getProfile() {

        $rules = [ 'vendor_id' => 'required|exists:users,id' ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->vendorRepository->find(\request('vendor_id'));

        if(!$model) return $this->error([], 'Invalid email');

        return $this->data($this->vendorRepository->parseModel($model));

    }

}
