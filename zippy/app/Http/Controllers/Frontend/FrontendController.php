<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Booking;

class FrontendController extends Controller
{

    public function home() {
        
        return view('frontend.home');
    }

    public function signin(Request $request) {
    	
    	if($request->isMethod('post')) {

    		$data = [
    			'email' => Input::get('email'),
    			'password' => Input::get('password')
    		];
    		if(request('login') == 'customer') $data['login_type'] = 'email';

    		if(request('login') == 'partner') $data['login_type'] = 'mobile';

    		$res = executeApi($data, encrypt('customers/signin'));

    		if($res->error) return redirect()->back()->with('error', $res->message);

            // $request->session()->put('user', $res->data->customer_details);
            if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {

                return redirect( route('frontend.profile') )->with(['success' => $res->message]);
            } else {
                return redirect()->back()->with('error', "You are not a valid user.");
            }

    		
    		
    	} else {
    		return view('frontend.login');	
    	}
    	
    }

    public function signup(Request $request) {
    	if($request->isMethod('post')) { 
    		// dd($request->all());
    		$data = [
    			'signup_type' => 'normal',
    			'first_name' => request('first_name'),
    			'last_name' => request('last_name'),
    			'email' => request('email'),
    			'mobile_no' => request('mobile_no'),
    			'password' => request('pass')
    		];
    		
    		if(request('signup') == 'individual') $data['customer_type'] = 1;

    		if(request('signup') == 'company') $data['customer_type'] = 2;

    		$res = executeApi($data, encrypt('customers/signup'));
    		
            if($res->error) return redirect()->back()->with('error', $res->message);
            // dd($res);
            session(['mobile_no' => $res->data->customer_details->mobile_no]);
            
            Auth::loginUsingId($res->data->customer_details->customer_id);

            return redirect(route('frontend.otpVerified'))->with('success', $res->message);    
            

    	} else {

    		return view('frontend.signup');	
    	}
    }

    public function forgot_password(Request $request) {

        if($request->isMethod('post')) {

            $res = executeApi($request->all(), encrypt('customers/forget-password'));

            if($res->error) return redirect()->back()->with('error', $res->message);

            return redirect()->back()->with('success', $res->message);
        } else {

            return view('frontend.forgot_password');
        }
    }

    public function booking(Request $request) {

        if($request->isMethod('post')) {
            $data = [
                'customer_id' => Auth::user()->id,
                'pickup_date' => date('Y-m-d h:a'),
                'type' => 2,
                'pickup_address' => request('pickup_address'),
                'drop_address' => request('drop_address'),
                'vehicle_type_id' => request('vehicle_type_id'),
                'no_of_vehicle' => 1,
                'actual_gross_weight' => request('actual_gross_weight'),
                'payment_type' => request('payment_type'),
                'cargo_type_id' => request('cargo_type_id')
            ];  

            $res = executeApi($data, encrypt('bookings/create'));
            
            if($res->error) return redirect()->back()->with('error', $res->message);

            return redirect()->back()->with('success', $res->message);

        } else {
            $cargos = [];
            $payment_types = [];
            $type_of_vehicles = [];

            $res = executeApi([], encrypt('typeOfCargos'));
            
            if(!$res->error) $cargos = $res->data->type_of_cargos;

            $res = executeApi([], encrypt('payment-types'));
            
            if(!$res->error) $payment_types = $res->data->results;

            $res = executeApi([], encrypt('typeOfVehicleRequired'));

            if(!$res->error) $type_of_vehicles = $res->data->type_of_vehicle_required;
            
            return view('frontend.booking', compact('cargos', 'payment_types', 'type_of_vehicles'));
        }
        
    }

    public function my_booking() {
        $pending = [];
        $completed = [];
        $cancel = [];
        $res = executeApi(['customer_id' => Auth::user()->id], encrypt('bookings/customer/my_history'));
        
        if( !$res->error ) $data = $res->data->history; 
        // dd($res);
        foreach ($data as $booking) {

            if ($booking->status == Booking::PENDING) {
                array_push($pending, $booking);
            }
            if ($booking->status == Booking::CANCEL) {
                array_push($cancel, $booking);
            }
            if ($booking->status == Booking::COMPLETE) {
                array_push($completed, $booking);
            }
        }
    	return view('frontend.my_booking', compact('pending', 'completed', 'cancel'));
    }

    public function booking_details($bookingId) {

        $res = executeApi(['booking_id' => $bookingId], encrypt('bookings/getDetails'));

        if($res->error) return redirect()->back()->with('error', 'No detail found.');

        $details = $res->data->results;

    	return view('frontend.booking_details', compact('details'));
    }

    public function vehicle_types() {

        $res = executeApi([], encrypt('typeOfVehicleRequired'));

        if(!$res->error) $type_of_vehicles = $res->data->type_of_vehicle_required;

    	return view('frontend.vehicle_types', compact('type_of_vehicles'));
    }

    public function trade_definition() {

        $res = executeApi(['slug' => 'trade-definitions'], encrypt('customers/get-page'));
        
        $page =  $res->data->page;

    	return view('frontend.trade_definition', compact('page'));
    }

    public function profile() {
        // $res = executeApi(['email' => session('email')], encrypt('customers/getProfile'));
        
        $user = Auth::user();

    	return view('frontend.my_profile', compact('user'));


    }

    public function signoutCustomer(Request $request) {

        // $res = executeApi($request->all(), encrypt('customers/signout'));

        // if($res->error) return redirect()->back()->with('error', $res->message);

        Auth::logout();

        return redirect(route('frontend.login'));
    }

    public function edit_profile(Request $request) {
        // dd($request->all());
        $res = executeApi($request->all(), encrypt('customers/updateProfile'));
        // dd($res);
        if($res->error) return redirect()->back()->with('error', $res->message);

        return redirect()->back()->with('success', $res->message);
    }

    public function otpVerified(Request $request) {

        if($request->isMethod('post')) {

            $res = executeApi(['mobile_no' => session('mobile_no'), 'otp' => request('otp')], encrypt('customers/verify-otp'));

            if($res->error) return redirect()->back()->with('error', $res->message);

            // Auth::loginUsingId($res->data->customer_details->customer_id);

            return redirect(route('frontend.profile'))->with('success', $res->message);
            
        } else {

            return view('frontend.verify_otp');
        }

        
    }

    public function resendOtp(Request $request) {

        $res = executeApi(['mobile_no' => $this->user->mobile_no], encrypt('customers/resend-otp'));

        if($res->error) return redirect()->back()->with('error', $res->message);


    }

    // public function email () {
    //     \Mail::send('emails.notifications', array('msg' => 'This is test message.'), function($message){
    //        $message 
    //            ->to('neuweg.shrikant@gmail.com', 'Zippy Support')
    //            ->bcc('pleasefindphp@gmail.com', 'PleaseFindPhp ')
    //            ->subject('New Notification');
    //     });
    // }
}
