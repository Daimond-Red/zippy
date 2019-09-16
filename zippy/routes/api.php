<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('payment-types', 'Api\BookingController@paymentTypes');

Route::group([ 'middleware' => 'api', 'namespace' => 'Api' ], function() {

    Route::post('getCountries', function (){

        return ['error' => false, 'data' => \App\Country::get_lists()];

    });

    Route::post('getStates', function (){

        $states = new \App\State();

        if( $id = \request('country_id') ) {
            $states = $states->where('country_id', $id);
        } else {
            $states = $states->where('country_id', \App\Country::DEFAULT_COUNTRY);
        }

        $states = $states->get(['title', 'id']);

        return ['error' => false, 'data' => $states];
    });

    Route::post('getCities', function (){

        $model = new \App\City();

        if( $id = \request('state_id') ) {
            $model = $model->where('state_id', $id);
        } else {
            $stateIds = \App\State::where('country_id', \App\Country::DEFAULT_COUNTRY)->pluck('id');
            $model = $model->whereIn('state_id', $stateIds);
        }

        if( $val = \request('name') ) $model = $model->where('title', 'like', '%'.trim($val).'%' );

        $cities = $model->orderBy('title')->limit(6)->get(['title', 'id']);

        return ['error' => false, 'data' => $cities];

    });

});

Route::group([ 'middleware' => 'api', 'prefix' => 'customers', 'namespace' => 'Api' ], function() {

    // get pages
    Route::post('get-page', 'PageController@index');

    // register
    Route::post('signup', 'CustomerController@register');

    // verify otp
    Route::post('verify-otp', 'CustomerController@verifyOtp');

    // resent otp
    Route::post('resend-otp', 'CustomerController@resentOtp');

    // login
    Route::post('signin', 'CustomerController@login');

    // forget password
    Route::post('forget-password', 'CustomerController@forgetPassword');

    // update customer profile
    Route::post('updateProfile', 'CustomerController@updateProfile');

    // signout customer
    Route::post('signout', 'CustomerController@signout');

    Route::post('getProfile', 'CustomerController@getProfile');

    Route::post('getOpenOrder', 'CustomerController@getOpenOrder');

});

Route::group([ 'middleware' => 'api', 'prefix' => 'vendors', 'namespace' => 'Api' ], function() {

    // register
    Route::post('signup', 'VendorController@register');

    // login
    Route::post('signin', 'VendorController@login');

    // forget password
    Route::post('forget-password', 'VendorController@forgetPassword');

    // update profile
    Route::post('updateProfile', 'VendorController@updateProfile');

    // signout vendor
    Route::post('signout', 'VendorController@signout');

    Route::post('pending/bidding', 'VendorController@pendingBidding');

    Route::post('confirm/bidding', 'VendorController@confirmBidding');

    Route::post('get/serviceableAreas', 'VendorController@getServiceableAreas');

    Route::post('update/serviceableAreas', 'VendorController@serviceableAreas');

    Route::post('delete/serviceableAreas', 'VendorController@deleteServiceableAreas');

    Route::post('getProfile', 'VendorController@getProfile');
    // accepted booking
    // cancel
    // in transit
    // complete
    // history

});

Route::group([ 'middleware' => 'api', 'namespace' => 'Api' ], function() {

    // type of cargos
    Route::post('typeOfCargos', 'CustomerController@typeOfCargos');

    Route::post('typeOfVehicleRequired', 'CustomerController@typeOfVehicleRequired');

    Route::post('vehicleCategories', 'CustomerController@vehicleCategories');

    Route::post('suggestedVehicles', 'CustomerController@suggestedVehicles');

    Route::post('chooseVehicles', 'CustomerController@chooseVehicles');

    Route::post('getAreas', 'VendorController@getAreas');

});

Route::group([ 'middleware' => 'api', 'prefix' => 'drivers', 'namespace' => 'Api' ], function() {

    Route::post('create', 'DriverController@store');
    Route::post('edit', 'DriverController@update');
    Route::post('delete', 'DriverController@destroy');
    Route::post('index', 'DriverController@index');

    Route::post('generate/password', 'DriverController@generatePassword');

    // driver login
    Route::post('login', 'DriverController@login');

    // otp verify
    Route::post('otpVerify', 'DriverController@otpVerify');

    // re-send otp
    Route::post('reSendOtp', 'DriverController@reSendOtp');

    // logout
    Route::post('logout', 'DriverController@logout');

    // open trip history
    Route::post('openTripHistory', 'DriverController@openTripHistory');

    // completed trip history
    Route::post('completedTripHistory', 'DriverController@completedTripHistory');

    // profile update
    Route::post('updateProfile', 'DriverController@updateProfile');

    // notification
    Route::post('notificationList', 'DriverController@notificationList');

});

Route::group([ 'middleware' => 'api', 'prefix' => 'vehicles', 'namespace' => 'Api' ], function() {

    Route::post('create', 'VehicleController@store');
    Route::post('edit', 'VehicleController@update');
    Route::post('delete', 'VehicleController@destroy');
    Route::post('index', 'VehicleController@index');

});

Route::group([ 'middleware' => 'api', 'prefix' => 'bookings', 'namespace' => 'Api' ], function() {

    // booking
    // create booking
    Route::post('create', 'BookingController@create');

    // accept booking
    Route::post('accept', 'BookingController@accept');

    // bidding on booking
    // vendor will bid on booking and admin will assign particular vendor
    Route::post('bidding', 'BookingController@biddingStore');

    // change booking status booking
    Route::post('booking-status', 'BookingController@updateStatus');

    // in cancel
    Route::post('cancel', 'BookingController@vendorCancel');

    // complete from vendor & rating
    Route::post('rating_by_vendor', 'BookingController@rating_by_vendor');

    // complete from customer & rating
    Route::post('rating_by_customer', 'BookingController@rating_by_customer');

    // booking history
    Route::post('customer/my_history', 'BookingController@customer_my_history');
    Route::post('customer/completed_history', 'BookingController@customer_completed_history');

    // on going history
    Route::post('vendor/my_history', 'BookingController@vendor_my_history');

    // completed history
    Route::post('vendor/completedHistory', 'BookingController@vendorCompletedHistory');

    Route::post('vendor/bidding_history', 'BookingController@vendor_bidding_history');

    Route::post('vendor/customer_request', 'BookingController@vendor_customer_request');

    Route::post('notifications', 'BookingController@userNotification');

    Route::post('customer/markBookingCancel', 'CustomerController@markBookingCancel');

    Route::post('customer/markConfirmBooking', 'CustomerController@markConfirmBooking');

    // By using this api vendor can change driver and vehicle in booking
    Route::post('vendor/changeDriversNVehicles', 'BookingController@changeDriversNVehicles');

    Route::post('vendors/getPendingRatingBookings', 'BookingController@vendorGetPendingRatingBookings');

    Route::post('vendor/markConfirm', 'BookingController@vendorMarkConfirm');

    Route::post('getDetails', 'BookingController@getDetails');

    Route::post('updateDetails', 'BookingController@updateDetails');

});