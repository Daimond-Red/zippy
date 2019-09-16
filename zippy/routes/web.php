<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', function () {

    try{
        \Mail::send('welcome', array('key' => 'value'), function($message)
        {
            $message->to('pleasefindphp@gmail.com', 'John Smith')->subject('Welcome!');
        });
    } catch (\Exception $e) {
        echo $e->getMessage(); die;
    }

});

// Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
//Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
//Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);

Route::get('home', [ 'uses' => 'HomeController@index', 'as' => 'admin.dashboard', 'middleware' => 'admin.auth']);

// Route::get('admin/live/tracking', ['uses' => 'HomeController@liveTracking', 'as' => 'admin.liveTracking']);

Route::get('logs', function(){

        if( request('clear') ) {
            \DB::table('logs')->truncate();
            return Redirect::to('admin/logs');
        }

        return view('admin.configurations.logs');
    });


Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('logs', function(){

        if( request('clear') ) {
            \DB::table('logs')->truncate();
            return Redirect::to('admin/logs');
        }

        return view('admin.configurations.logs');
    });

    Route::get('cargos', [ 'as' => 'admin.cargos.index', 'uses' => 'CargotypeController@index' ]);
    Route::get('cargos/create', [ 'as' => 'admin.cargos.create', 'uses' => 'CargotypeController@create' ]);
    Route::post('cargos', [ 'as' => 'admin.cargos.store', 'uses' => 'CargotypeController@store' ]);
    Route::get('cargos/{id}', [ 'as' => 'admin.cargos.show', 'uses' => 'CargotypeController@show' ]);
    Route::get('cargos/{id}/edit', [ 'as' => 'admin.cargos.edit', 'uses' => 'CargotypeController@edit' ]);
    Route::put('cargos/{id}', [ 'as' => 'admin.cargos.update', 'uses' => 'CargotypeController@update' ]);
    Route::get('cargos/{id}/destroy', [ 'as' => 'admin.cargos.delete', 'uses' => 'CargotypeController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('vehicletypes', [ 'as' => 'admin.vehicletypes.index', 'uses' => 'VehicletypeController@index' ]);
    Route::get('vehicletypes/create', [ 'as' => 'admin.vehicletypes.create', 'uses' => 'VehicletypeController@create' ]);
    Route::post('vehicletypes', [ 'as' => 'admin.vehicletypes.store', 'uses' => 'VehicletypeController@store' ]);
    Route::get('vehicletypes/{id}', [ 'as' => 'admin.vehicletypes.show', 'uses' => 'VehicletypeController@show' ]);
    Route::get('vehicletypes/{id}/edit', [ 'as' => 'admin.vehicletypes.edit', 'uses' => 'VehicletypeController@edit' ]);
    Route::put('vehicletypes/{id}', [ 'as' => 'admin.vehicletypes.update', 'uses' => 'VehicletypeController@update' ]);
    Route::get('vehicletypes/{id}/destroy', [ 'as' => 'admin.vehicletypes.delete', 'uses' => 'VehicletypeController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('vehiclecategories', [ 'as' => 'admin.vehiclecategories.index', 'uses' => 'VehiclecategoryController@index' ]);
    Route::get('vehiclecategories/create', [ 'as' => 'admin.vehiclecategories.create', 'uses' => 'VehiclecategoryController@create' ]);
    Route::post('vehiclecategories', [ 'as' => 'admin.vehiclecategories.store', 'uses' => 'VehiclecategoryController@store' ]);
    Route::get('vehiclecategories/{id}', [ 'as' => 'admin.vehiclecategories.show', 'uses' => 'VehiclecategoryController@show' ]);
    Route::get('vehiclecategories/{id}/edit', [ 'as' => 'admin.vehiclecategories.edit', 'uses' => 'VehiclecategoryController@edit' ]);
    Route::put('vehiclecategories/{id}', [ 'as' => 'admin.vehiclecategories.update', 'uses' => 'VehiclecategoryController@update' ]);
    Route::get('vehiclecategories/{id}/destroy', [ 'as' => 'admin.vehiclecategories.delete', 'uses' => 'VehiclecategoryController@destroy' ]);    

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('customers', [ 'as' => 'admin.customers.index', 'uses' => 'CustomerController@index' ]);
    Route::get('customers/create', [ 'as' => 'admin.customers.create', 'uses' => 'CustomerController@create' ]);
    Route::post('customers', [ 'as' => 'admin.customers.store', 'uses' => 'CustomerController@store' ]);
    Route::get('customers/{id}', [ 'as' => 'admin.customers.show', 'uses' => 'CustomerController@show' ]);
    Route::get('customers/{id}/edit', [ 'as' => 'admin.customers.edit', 'uses' => 'CustomerController@edit' ]);
    Route::put('customers/{id}', [ 'as' => 'admin.customers.update', 'uses' => 'CustomerController@update' ]);
    Route::get('customers/{id}/destroy', [ 'as' => 'admin.customers.delete', 'uses' => 'CustomerController@destroy' ]);
    Route::get('search/customers', [ 'as' => 'admin.customers.search', 'uses' => 'CustomerController@search' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('vendors', [ 'as' => 'admin.vendors.index', 'uses' => 'VendorController@index' ]);
    Route::get('vendors/create', [ 'as' => 'admin.vendors.create', 'uses' => 'VendorController@create' ]);
    Route::post('vendors', [ 'as' => 'admin.vendors.store', 'uses' => 'VendorController@store' ]);
    Route::get('vendors/{id}', [ 'as' => 'admin.vendors.show', 'uses' => 'VendorController@show' ]);
    Route::get('vendors/{id}/edit', [ 'as' => 'admin.vendors.edit', 'uses' => 'VendorController@edit' ]);
    Route::put('vendors/{id}', [ 'as' => 'admin.vendors.update', 'uses' => 'VendorController@update' ]);
    Route::get('vendors/{id}/destroy', [ 'as' => 'admin.vendors.delete', 'uses' => 'VendorController@destroy' ]);
    Route::get('search/vendors', [ 'as' => 'admin.vendors.search', 'uses' => 'VendorController@search' ]);

    Route::get('vendors/{vendor_id}/drivers', ['uses' => 'DriverController@index_driver', 'as' => 'admin.drivers.index']);
    Route::get('vendors/{vendor_id}/add_driver', ['uses' => 'DriverController@add_driver', 'as' => 'admin.drivers.create']);
    Route::post('vendors/{vendor_id}/add_driver', ['uses' => 'DriverController@store_driver', 'as' => 'admin.drivers.store']);
    Route::get('vendors/{vendor_id}/edit_driver/{driver_id}', ['uses' => 'DriverController@edit_driver', 'as' => 'admin.drivers.edit']);
    Route::put('vendors/{vendor_id}/edit_driver/{driver_id}', ['uses' => 'DriverController@update_driver', 'as' => 'admin.drivers.update']);
    Route::get('vendors/{vendor_id}/delete_driver/{driver_id}', ['uses' => 'DriverController@delete_driver', 'as' => 'admin.drivers.delete']);

    Route::get('vendors/{vendor_id}/vehicles', ['uses' => 'VehicleController@index_vehicle', 'as' => 'admin.vehicles.index']);
    Route::get('vendors/{vendor_id}/add_vehicle', ['uses' => 'VehicleController@add_vehicle', 'as' => 'admin.vehicles.create']);
    Route::post('vendors/{vendor_id}/add_vehicle', ['uses' => 'VehicleController@store_vehicle', 'as' => 'admin.vehicles.store']);
    Route::get('vendors/{vendor_id}/edit_vehicle/{vehicle_id}', ['uses' => 'VehicleController@edit_vehicle', 'as' => 'admin.vehicles.edit']);
    Route::put('vendors/{vendor_id}/edit_vehicle/{vehicle_id}', ['uses' => 'VehicleController@update_vehicle', 'as' => 'admin.vehicles.update']);
    Route::get('vendors/{vendor_id}/delete_vehicle/{vehicle_id}', ['uses' => 'VehicleController@delete_vehicle', 'as' => 'admin.vehicles.delete']);

    Route::get('vendors/{vendor_id}/areas', ['uses' => 'VendorController@indexAreas', 'as' => 'admin.vendors.areas']);
    Route::post('vendors/{vendor_id}/storeAreas', ['uses' => 'VendorController@storeAreas', 'as' => 'admin.vendors.storeAreas']);
    Route::post('vendors/{base_city_id}/{vendor_id}/updateAreas', ['uses' => 'VendorController@updateAreas', 'as' => 'admin.vendors.updateAreas']);
    Route::get('vendors/{vendor_id}/deleteAreas', ['uses' => 'VendorController@deleteAreas', 'as' => 'admin.vendors.deleteAreas']);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('areas', [ 'as' => 'admin.areas.index', 'uses' => 'AreaController@index' ]);
    Route::get('areas/create', [ 'as' => 'admin.areas.create', 'uses' => 'AreaController@create' ]);
    Route::post('areas', [ 'as' => 'admin.areas.store', 'uses' => 'AreaController@store' ]);
    Route::get('areas/{id}', [ 'as' => 'admin.areas.show', 'uses' => 'AreaController@show' ]);
    Route::get('areas/{id}/edit', [ 'as' => 'admin.areas.edit', 'uses' => 'AreaController@edit' ]);
    Route::put('areas/{id}', [ 'as' => 'admin.areas.update', 'uses' => 'AreaController@update' ]);
    Route::get('areas/{id}/destroy', [ 'as' => 'admin.areas.delete', 'uses' => 'AreaController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('pages', [ 'as' => 'admin.pages.index', 'uses' => 'PageController@index' ]);
    Route::get('pages/create', [ 'as' => 'admin.pages.create', 'uses' => 'PageController@create' ]);
    Route::post('pages', [ 'as' => 'admin.pages.store', 'uses' => 'PageController@store' ]);
    Route::get('pages/{id}', [ 'as' => 'admin.pages.show', 'uses' => 'PageController@show' ]);
    Route::get('pages/{id}/edit', [ 'as' => 'admin.pages.edit', 'uses' => 'PageController@edit' ]);
    Route::put('pages/{id}', [ 'as' => 'admin.pages.update', 'uses' => 'PageController@update' ]);
    Route::get('pages/{id}/destroy', [ 'as' => 'admin.pages.delete', 'uses' => 'PageController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){
    Route::get('globalSearch', [ 'as' => 'admin.globalSearch', 'uses' => 'UserController@globalSearch' ]);
});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('appNotifications', [ 'as' => 'admin.appNotifications.index', 'uses' => 'AppNotificationController@index' ]);
    Route::get( 'appNotifications/create', [ 'as' => 'admin.appNotifications.create', 'uses' => 'AppNotificationController@create' ]);
    Route::post('appNotifications', [ 'as' => 'admin.appNotifications.store', 'uses' => 'AppNotificationController@store' ]);
    Route::get('appNotifications/{id}', [ 'as' => 'admin.appNotifications.show', 'uses' => 'AppNotificationController@show' ]);
    Route::get('appNotifications/{id}/edit', [ 'as' => 'admin.appNotifications.edit', 'uses' => 'AppNotificationController@edit' ]);
    Route::put('appNotifications/{id}', [ 'as' => 'admin.appNotifications.update', 'uses' => 'AppNotificationController@update' ]);
    Route::get('appNotifications/{id}/destroy', [ 'as' => 'admin.appNotifications.delete', 'uses' => 'AppNotificationController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('driverNotifications', [ 'as' => 'admin.driverNotifications.index', 'uses' => 'DriverNotificationController@index' ]);
    Route::get('driverNotifications/create', [ 'as' => 'admin.driverNotifications.create', 'uses' => 'DriverNotificationController@create' ]);
    Route::post('driverNotifications', [ 'as' => 'admin.driverNotifications.store', 'uses' => 'DriverNotificationController@store' ]);
    Route::get('driverNotifications/{id}', [ 'as' => 'admin.driverNotifications.show', 'uses' => 'DriverNotificationController@show' ]);
    Route::get('driverNotifications/{id}/edit', [ 'as' => 'admin.driverNotifications.edit', 'uses' => 'DriverNotificationController@edit' ]);
    Route::put('driverNotifications/{id}', [ 'as' => 'admin.driverNotifications.update', 'uses' => 'DriverNotificationController@update' ]);
    Route::get('driverNotifications/{id}/destroy', [ 'as' => 'admin.driverNotifications.delete', 'uses' => 'DriverNotificationController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('payment-types', [ 'as' => 'admin.paymentTypes.index', 'uses' => 'PaymentTypeController@index' ]);
    Route::get('payment-types/create', [ 'as' => 'admin.paymentTypes.create', 'uses' => 'PaymentTypeController@create' ]);
    Route::post('payment-types', [ 'as' => 'admin.paymentTypes.store', 'uses' => 'PaymentTypeController@store' ]);
    Route::get('payment-types/{id}', [ 'as' => 'admin.paymentTypes.show', 'uses' => 'PaymentTypeController@show' ]);
    Route::get('payment-types/{id}/edit', [ 'as' => 'admin.paymentTypes.edit', 'uses' => 'PaymentTypeController@edit' ]);
    Route::put('payment-types/{id}', [ 'as' => 'admin.paymentTypes.update', 'uses' => 'PaymentTypeController@update' ]);
    Route::get('payment-types/{id}/destroy', [ 'as' => 'admin.paymentTypes.delete', 'uses' => 'PaymentTypeController@destroy' ]);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('pending/bookings', ['as' => 'admin.bookings.pending', 'uses' => 'BookingController@pending']);
    Route::get('assign/vendors/{id}/bookings', ['as' => 'admin.bookings.assign_vendor', 'uses' => 'BookingController@assign_vendor']);
    Route::post('assign/vendors/{id}/bookings', ['as' => 'admin.bookings.assign_vendor_store', 'uses' => 'BookingController@assign_vendor_store']);

    // custom assign
    Route::get('custom_assign/vendors/{id}/bookings', ['as' => 'admin.bookings.custom_assign_vendor', 'uses' => 'BookingController@assign_vendor']);
    Route::post('custom_assign/vendors/{id}/bookings', ['as' => 'admin.bookings.custom_assign_vendor_store', 'uses' => 'BookingController@assign_vendor_store']);
    Route::post('custom_assign_bidding/vendors/{id}/bookings', ['as' => 'admin.bookings.custom_assign_bidding_vendor_store', 'uses' => 'BookingController@assign_bidding_vendor_store']);

    Route::post('manual_assign_bidding/vendors/{id}/bookings', ['as' => 'admin.bookings.manualAssignBiddingVendorStore', 'uses' => 'BookingController@manualAssignBiddingVendorStore']);

    Route::get('bookings/index', [ 'as' => 'admin.bookings.index', 'uses' => 'BookingController@index' ]);
    Route::get('bookings/cancelled', [ 'as' => 'admin.bookings.cancelled', 'uses' => 'BookingController@cancelled' ]);
    Route::get('bookings/completed', [ 'as' => 'admin.bookings.completed', 'uses' => 'BookingController@completed' ]);
    Route::get('bookings/expired', [ 'as' => 'admin.bookings.expired', 'uses' => 'BookingController@expired' ]);

    Route::get('bookings/{id}', [ 'as' => 'admin.bookings.show', 'uses' => 'BookingController@show' ]);
    
    Route::get('send/notification/{id}', [ 'as' => 'admin.notification.send', 'uses' => 'BookingController@sendNotification' ]);
    Route::post('bookingNotifications', ['as' => 'admin.bookingNotification.store', 'uses' => 'BookingNotificationController@store']);

    Route::get('booking/{id}/edit', [ 'as' => 'admin.bookings.edit', 'uses' => 'BookingController@edit' ]);
    Route::put('booking/{id}', [ 'as' => 'admin.bookings.update', 'uses' => 'BookingController@update' ]);

    Route::get('bookings/{id}/bill', [ 'as' => 'admin.bookings.showBill', 'uses' => 'BookingController@showBill' ]);
    Route::post('bookings/{id}/bill', [ 'as' => 'admin.bookings.showBillStore', 'uses' => 'BookingController@showBillStore' ]);

    Route::get('bookings/{id}/cancel', [ 'as' => 'admin.bookings.cancelBooking', 'uses' => 'BookingController@cancelBooking' ]);

    // admin can also bid on booking for this we need to assign vendor and amount
    Route::get('booking/{id}/bid', ['uses' => 'BookingController@bid', 'as' => 'admin.bookings.bid']);
    Route::post('booking/{id}/bid', ['uses' => 'BookingController@bidStore', 'as' => 'admin.bookings.bidStore']);

    // assign drivers
    Route::get('booking/{id}/assignVendor', ['uses' => 'BookingController@assignVendor', 'as' => 'admin.bookings.assignVendor']);
    Route::post('booking/{id}/assignVendor', ['uses' => 'BookingController@assignVendorStore', 'as' => 'admin.bookings.assignVendorStore']);

    Route::get('markBookingCancel/{id}', ['as' => 'admin.bookings.markBookingCancel', 'uses' => 'BookingController@markBookingCancel']);

});



Route::group([ 'prefix' => config('app.admin_prefix', 'admin/templates'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('getDriverVehicleDropdown', ['uses' => 'TemplateController@getDriverVehicleDropdown', 'as' => 'templates.getDriverVehicleDropdown']);

});

Route::group([ 'prefix' => config('app.admin_prefix', 'admin'), 'middleware' => 'admin.auth', 'namespace' => 'Admin' ], function(){

    Route::get('push/configurations', ['uses' => 'AppConfigController@configurations', 'as' => 'config.push']);

    Route::post('push/user1/store', ['uses' => 'AppConfigController@push_user1_store', 'as' => 'config.push_user1_store']);

    Route::post('push/user2/store', ['uses' => 'AppConfigController@push_user2_store', 'as' => 'config.push_user2_store']);

    Route::get('push/send', ['uses' => 'AppConfigController@send_create', 'as' => 'config.send_create']);

    Route::post('push/send', ['uses' => 'AppConfigController@send', 'as' => 'config.send']);

    Route::get('translation', ['uses' => 'AppConfigController@translation', 'as' => 'config.translation']);
    Route::post('translation', ['uses' => 'AppConfigController@translationStore', 'as' => 'config.translationStore']);
    Route::post('translation/{id}/update', ['uses' => 'AppConfigController@translationUpdate', 'as' => 'config.translationUpdate']);
    Route::get('translation/{id}/remove', ['uses' => 'AppConfigController@translationRemove', 'as' => 'config.translationRemove']);

    Route::get('search/cities', [ 'as' => 'admin.cities.search', 'uses' => 'UserController@searchCities' ]);
    Route::get('search/states', [ 'as' => 'admin.states.search', 'uses' => 'UserController@searchStates' ]);

    Route::get('dashboard/text', ['uses' => 'AppConfigController@dashboardText', 'as' => 'admin.dashboardText']);
    Route::post('dashboard/text', ['uses' => 'AppConfigController@dashboardTextStore', 'as' => 'admin.dashboardTextStore']);

});




Route::group(['namespace' => 'Frontend'], function() {
    
    Route::get('/', ['uses' => 'FrontendController@home', 'as' => 'frontend.home']);
    Route::match(['get', 'post'], 'signin', ['uses' => 'FrontendController@signin', 'as' => 'frontend.login']);
    Route::match(['get', 'post'], 'signup', ['uses' => 'FrontendController@signup', 'as' => 'frontend.signup']);
    Route::match(['get', 'post'], 'forgot-password', ['uses' => 'FrontendController@forgot_password', 'as' =>'frontend.forgot_password']);
    

    Route::match(['get', 'post'], 'otpVerified', ['uses' => 'FrontendController@otpVerified', 'as' => 'frontend.otpVerified']);
    Route::post('resendOtp', ['uses' => 'FrontendController@resendOtp', 'as' => 'frontend.resendOtp']);

    // Route::get('mailCheck', 'FrontendController@email');
});

Route::group(['namespace' => 'Frontend', 'middleware' => 'customer.auth'], function() { 
    
    Route::match(['get', 'post'], 'booking', ['uses' => 'FrontendController@booking', 'as' => 'frontend.booking']);    
    Route::get('my_booking', ['uses' => 'FrontendController@my_booking', 'as' => 'frontend.my_booking']);
    Route::get('booking-details/{booking_id}', ['uses' => 'FrontendController@booking_details', 'as' => 'frontend.booking_details']);
    Route::get('vehicle-types', ['uses' => 'FrontendController@vehicle_types', 'as' => 'frontend.vehicle_types']);
    Route::get('trade-definition', ['uses' => 'FrontendController@trade_definition', 'as' => 'frontend.trade_definition']);
    Route::get('my-profile', ['uses' => 'FrontendController@profile', 'as' => 'frontend.profile']);

    Route::post('edit-profile', ['uses' => 'FrontendController@edit_profile', 'as' => 'frontend.edit_profile']);

    Route::match(['get', 'post'], 'signout-customer', ['uses' => 'FrontendController@signoutCustomer', 'as' => 'frontend.signoutCustomer']);

});
// Route::get('econsignment', [ 'uses' => 'HomeController@econsignment', 'as' => 'admin.econsignment', 'middleware' => 'admin.auth']);