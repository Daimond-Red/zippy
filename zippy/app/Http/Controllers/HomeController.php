<?php

namespace App\Http\Controllers;

use App\Area;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\Basecode\Classes\Repositories\CustomerRepository;
use App\Basecode\Classes\Repositories\VendorRepository;
use App\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public $customerRepository, $vendorRepository, $bookingRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        VendorRepository $vendorRepository,
        BookingRepository $bookingRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->vendorRepository = $vendorRepository;
        $this->bookingRepository = $bookingRepository;

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // latest 5 customers
        $latest_customers = $this->customerRepository->getCollection()->take(5)->get();

        // latest 5 vendors
        $latest_vendors = $this->vendorRepository->getCollection()->take(5)->get();

        // latest 5 bookings
        $pending_bookings = $this->bookingRepository->getCollection()->where('status', Booking::PENDING)->take(5)->get();

        $customer_count = $this->customerRepository->getCollection()->count();
        $vendor_count = $this->vendorRepository->getCollection()->count();
        $pending_booking_count = $this->bookingRepository->getCollection()->where('status', Booking::PENDING)->count();
        $ongoing_booking_count = $this->bookingRepository->getCollection()->whereNotIn('status', [Booking::PENDING, Booking::COMPLETE, Booking::CANCEL])->count();

        // vendors count booking wise
        $vendors_count = \App\BookingLog::select('booking_id', \DB::raw('count(*) as count'))->groupBy('booking_id')->pluck('count', 'booking_id');

        return view('home', compact(
            'latest_customers',
            'latest_vendors',
            'pending_bookings',
            'vendors_count',
            'customer_count',
            'vendor_count',
            'pending_booking_count',
            'ongoing_booking_count'
        ));
    }
    public function econsignment() {
        
        return view('econsignment');
    }
//    public function liveTracking() {
//        return view('admin.liveTracking');
//    }
}
