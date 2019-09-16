<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\DriverRepository;
use App\Basecode\Classes\Repositories\VehicleRepository;
use App\Basecode\Classes\Repositories\VendorRepository;
use App\Booking;
use App\Basecode\Classes\Repositories\BookingRepository;
use App\Basecode\Classes\Permissions\Permission;
use App\BookingBid;
use App\BookingLog;
use App\User;
use App\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class BookingController extends BackendController {

    public $vehicleRepository, $driverRepository, $vendorRepository;

    public function __construct(
        BookingRepository $repository,
        VehicleRepository $vehicleRepository,
        DriverRepository $driverRepository,
        Permission $permission,
        VendorRepository $vendorRepository
    ) {
        $this->repository = $repository;
        $this->vehicleRepository = $vehicleRepository;
        $this->driverRepository = $driverRepository;
        $this->permission = $permission;
        $this->vendorRepository = $vendorRepository;
    }

    public function pending() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository->getCollection()->where('status', Booking::PENDING)->orderBy('updated_at', 'desc')->get();

        $vendors_count = BookingLog::select('booking_id', \DB::raw('count(*) as count'))->groupBy('booking_id')->pluck('count', 'booking_id');

        return view('admin.bookings.pending', compact('collection', 'vendors_count'));

    }

    public function assign_vendor($id) {

        if(! $this->permission->show() ) return;

        $model = $this->repository->find($id);

        // WE CAN ONLY ASSIGN VENDOR IN CASE OF PENDING BOOKING
        // OTHERWISE WE WILL REDIRECT TO DASHBOARD WITH ERROR.
        if( $model->status != Booking::PENDING ) return redirectToDashboard();

        $logs = BookingLog::where('booking_id', $model->id)->with(['vendor', 'driver', 'vehicle'])->get();
        $vendors = $this->repository->getRelatedVendors($model->vehicle_category_id)->toArray();
        $vendorLists = User::where('role', User::VENDOR)->whereIn('id',array_column($vendors, 'id'))->with(['drivers', 'vehicles'])->get()->toArray();

        $biddings = BookingBid::where('booking_id', $id)->get();

        if( $model->type == Booking::TYPE_INTER ) return view('admin.bookings.assign_bidder', compact('model', 'logs', 'vendorLists', 'biddings'));

        return view('admin.bookings.assign_vendor', compact('model', 'logs', 'vendorLists'));

    }

    public function assign_vendor_store($id) {

        if(! $this->permission->show() ) return;

        $model = $this->repository->find($id);

        // WE CAN ONLY ASSIGN VENDOR IN CASE OF PENDING BOOKING
        // OTHERWISE WE WILL REDIRECT TO DASHBOARD WITH ERROR.
        if( $model->status != Booking::PENDING ) return redirectToDashboard();
        $vendor_id = 0;
        $driver_id = 0;
        $vehicle_id = 0;
        if(request('vendor_id') > 0){
            $vendor_id = request('vendor_id');
            $driver_id = request('driver_id_'.$vendor_id);
            $vehicle_id = request('vehicle_id_'.$vendor_id);
        }else{
            $log = BookingLog::find(request('id'));
            if(! ($log && ($log->booking_id != request('id'))) ) return redirectToDashboard();

            $vendor_id = $log->vendor_id;
            $driver_id = $log->driver_id;
            $vehicle_id = $log->vehicle_id;
            $log->status = 2;
            $log->save();
        }
        
        $model->vendor_id = $vendor_id;
        $model->driver_id = $driver_id;
        $model->vehicle_id = $vehicle_id;
        $model->status = 2;
        $model->save();

        return $this->repository->redirectBackWithSuccess('Vendor assigned successfully', 'admin.bookings.pending');

    }

    public function assign_bidding_vendor_store($id) {

        if(! $this->permission->show() ) return;

        request()->validate(['id' => 'required', 'amount' => 'required']);

        $model = $this->repository->find($id);

        if( $model->status != Booking::PENDING ) return redirectToDashboard();

        $bid = BookingBid::where('booking_id', $id)->where('id', request('id'))->first();

        if(!$bid) { // this for manual

            $bid = new BookingBid;
            $bid->booking_id = $id;
            $bid->customer_id = $model->customer_id;
            $bid->vendor_id = request('id');
            $bid->amount = request('amount');

        }

        $bid->status = Booking::CONFIRMATION_PENDING;
        $bid->save();

        $otherVendorIds = BookingBid::where('booking_id', $id)->where('id', '!=', request('id'))->pluck('vendor_id')->toArray();
        
        BookingBid::where('booking_id', $id)->where('id', '!=', request('id'))->update(['status' => \App\BookingBid::CLOSE]);

        $model->total_amount = $bid->amount;
        $model->customer_amount = request('amount');
        $model->vendor_id = $bid->vendor_id;
        $model->status = Booking::CONFIRMATION_PENDING;
        $model->save();

        $vendor = $this->vendorRepository->find( $bid->vendor_id );

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('client_quote_42'));
        $msg = str_replace('{AMOUNT}', request('amount'), $msg);

        sendNotification($model->customer_id, [
            'booking_id'    => $model->id,
            'category'      => 'vendor_assign',
            'body'          => $msg
        ]);

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('vendor_assignment_push_44'));
        //$msg = str_replace('{AMOUNT}', request('amount'), $msg);

        sendNotification($model->vendor_id, [
            'booking_id'    => $model->id,
            'category'      => 'bid_confirm',
            'body'          => $msg
        ]);
        
        $msg = "Booking/Order ID #".$model->id."stands closed"; //  or Order ID( ". $model->id ." ) request closed.";

        sendNotification($otherVendorIds, [
            'booking_id'    => $model->id,
            'category'      => 'booking_closed',
            'body'          => $msg
        ]);

        $this->repository->createBookingLog($model->id, $model->vendor_id, User::VENDOR, Booking::CONFIRMATION_PENDING);

        return $this->repository->redirectBackWithSuccess('Vendor assigned successfully', 'admin.bookings.pending');

    }

    public function manualAssignBiddingVendorStore($id) {

        if(! $this->permission->show() ) return;

        request()->validate([
            'vendor_id'     => 'required',
            'amount'        => 'required',
            'driver_id'     => 'required',
            'vehicle_id'    => 'required',
        ]);

        $model = $this->repository->find($id);

        if( $model->no_of_vehicle && count(request('driver_id')) != $model->no_of_vehicle && count(request('vehicle_id')) != $model->no_of_vehicle ) return redirect()->back()->withErrors($model->no_of_vehicle. ' drivers & '. $model->no_of_vehicle. ' vehicles required');

        if( $model->status != Booking::PENDING ) return redirectToDashboard();

        try {

            \DB::beginTransaction();

            // save bid model
            $bid = new BookingBid();
            $bid->amount = request('amount');
            $bid->booking_id = $id;
            $bid->customer_id = $model->customer_id;
            $bid->vendor_id = request('vendor_id');
            $bid->status = Booking::CONFIRMATION_PENDING;
            $bid->save();

            $driverIds = request('driver_id');
            $vehicleIds = request('vehicle_id');

            // save driver and vehicle history
            foreach( $driverIds as $index => $driverId ) {

                $attrs = [];
                $attrs['booking_id'] = $model->id;
                $attrs['customer_id'] = $model->customer_id;
                $attrs['vendor_id'] = request('vendor_id');
                $attrs['driver_id'] = $driverId;
                $attrs['vehicle_id'] = $vehicleIds[$index];
                $attrs['status'] = Booking::CONFIRMATION_PENDING;

                $bookingLog = new BookingLog;
                $bookingLog->fill($attrs);
                $bookingLog->save();
            }

            $model->vendor_id = request('vendor_id');
            $model->total_amount = request('amount');
            $model->customer_amount = request('amount');
            $model->status = Booking::CONFIRMATION_PENDING;
            $model->save();

            $vendor = $this->vendorRepository->find( request('vendor_id') );

            sendNotification($model->customer_id, [
                'booking_id'    => $model->id,
                'category'      => 'vendor_assign',
                'body'          => implode(' ', [$vendor->first_name, $vendor->last_name]). ' has been assigned for your booking #'. $model->id. '. Please check and confirm'
            ]);


            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
             //echo $e->getMessage(); die;
            return redirect()->back()->withErrors('Something went wrong');
        }

        return $this->repository->redirectBackWithSuccess('Vendor assigned successfully', 'admin.bookings.pending');

    }

    public function index() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository
                        ->getCollection()
                        ->whereNotIn('status', [Booking::PENDING, Booking::CANCEL, Booking::COMPLETE, Booking::EXPIRED])
                        ->with(['booking_status'])
                        ->orderBy('updated_at', 'desc')
                        ->get();

        return view($this->repository->viewIndex, [
            'collection' => $collection,
            'repository' => $this->repository
        ]);

    }

    public function cancelled() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository
                        ->getCollection()
                        ->where('status', Booking::CANCEL)
                        ->with(['booking_status'])
                        ->get();

        return view('admin.bookings.cancelled', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);

    }

    public function completed() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository
                        ->getCollection()
                        ->where('status', Booking::COMPLETE)
                        ->with(['booking_status'])
                        ->get();

        return view('admin.bookings.completed', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);

    }

    public function expired() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository
            ->getCollection()
            ->where('status', Booking::EXPIRED)
            ->with(['booking_status'])
            ->get();

        return view('admin.bookings.expired', [
            'collection' => $collection,
            'repository' => $this->repository
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        if(! $this->permission->show() ) return;

        $model = $this->repository->find($id);

        $vehicleIds = BookingLog::where('booking_id', $id)->pluck('vehicle_id');
        $vehicles = $this->vehicleRepository->getCollection()->whereIn('id', $vehicleIds)->get();

        $driverIds = BookingLog::where('booking_id', $id)->pluck('driver_id');
        $drivers = $this->driverRepository->getCollection()->whereIn('id', $driverIds)->get();

        return view($this->repository->viewShow, [
            'model'         => $model,
            'repository'    => $this->repository,
            'drivers'       => $drivers,
            'vehicles'      => $vehicles,
        ]);

    }

    public function sendNotification($id) {
        
        $model = $this->repository->find($id);

        $vehicleIds = BookingLog::where('booking_id', $id)->pluck('vehicle_id');
        $vehicles = $this->vehicleRepository->getCollection()->whereIn('id', $vehicleIds)->get();

        $driverIds = BookingLog::where('booking_id', $id)->pluck('driver_id');
        $drivers = $this->driverRepository->getCollection()->whereIn('id', $driverIds)->get();

        return view('admin.bookings.notification', [
            'model'         => $model,
            'repository'    => $this->repository,
            'drivers'       => $drivers,
            'vehicles'      => $vehicles,
        ]);
    }

    public function showBill( $id ) {

        if(! $this->permission->show() ) return;

        $model = $this->repository->find($id);

        return view('admin.bookings.bill', compact('model'));

    }

    public function showBillStore( $id ) {

        if(! $this->permission->show() ) return;

        $model = $this->repository->find($id);

        $model = $this->repository->update($model, request()->all());

        return $this->repository->redirectBackWithSuccess('Updated Successfully');

    }

    public function bid( $id ) {

        $model = $this->repository->find($id);

        $vendors = $this->repository->getVendorWhoNotBidOnBooking($id)->pluck('email', 'id');

        return view('admin.bookings.bid', compact('model', 'vendors'));


    }

    public function bidStore( $id ) {

        request()->validate(['vendor_id' => 'required|exists:users,id', 'amount' => 'required']);

        $model = $this->repository->find($id);

        $vendor = $this->vendorRepository->find(request('vendor_id'));

        $bookingBidModel = BookingBid::whereBookingId($id)->whereVendorId(request('vendor_id'))->first();
        if( $bookingBidModel ) return redirect()->back()->withErrors('Vendor already has a bid on this booking');

        $bookingBidModel = new BookingBid();
        $bookingBidModel->booking_id = $model->id;
        $bookingBidModel->customer_id = $model->customer_id;
        $bookingBidModel->vendor_id = request('vendor_id');
        $bookingBidModel->amount = request('amount');
        $bookingBidModel->save();

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('vendor_quote_confirmation_41'));

        sendNotification(request('vendor_id'), [
            'booking_id'    => $model->id,
            'category'      => 'admin_bid_store',
            'body'          => $msg
        ]);

        return $this->repository->redirectBackWithSuccess('Bid provided successfully');

    }

    public function assignVendor($id) {

        $booking = $this->repository->find($id);

        $vendor = $this->vendorRepository->find($booking->vendor_id);

        $vendors = $this->vendorRepository
                        ->getBasedOnBaseNDropCity($booking->pickup_city_id, $booking->drop_city_id, $booking->vehicle_type_id, [$booking->vendor_id])
                        ->get();

        $assignDriverIds = BookingLog::where('booking_id', $id)->pluck('driver_id');
        $assignVehicleIds = BookingLog::where('booking_id', $id)->pluck('vehicle_id');

        $biddingAmounts = BookingBid::where('booking_id', $id)->pluck('amount', 'vendor_id');

        return view('admin.bookings.assignDrivers', compact(
            'vendor',
            'vendors',
            'booking',
            'biddingAmounts',
            'assignDriverIds',
            'assignVehicleIds'
        ));

    }

    public function assignVendorStore($id) {

        $model = $this->repository->find($id);

        request()->validate(['vendor' => 'required', 'amount' => 'required']);

        if(!request('amount')) return redirect()->back()->withErrors('Invalid amount');

        $driverIds = \request('drivers_'. $model->vendor_id);
        $vehicleIds = \request('vehicles_'. $model->vendor_id);
        if( count($driverIds) && ( count($driverIds) != $model->no_of_vehicle ) && (count($driverIds) != count($vehicleIds)) ) return redirect()->back()->withErrors('Invalid driver and vehicle selected');

        $assignDriverIds = BookingLog::where('booking_id', $id)->pluck('driver_id');

        if( blank($assignDriverIds) ) {

            foreach ( $driverIds as $index => $driverId ) {
                $log = new BookingLog();
                $log->booking_id = $model->id;
                $log->customer_id = $model->customer_id;
                $log->vendor_id = \request('vendor');
                $log->driver_id = $driverIds[$index];
                $log->vehicle_id = $vehicleIds[$index];
                $log->save();
            }

            // will get vehicles numbers
            $vehicleNos = Vehicle::whereIn('id', $vehicleIds)->pluck('registration_no')->toArray();
            // will get drivers names
            $names = User::whereIn('id', $driverIds)->pluck('first_name')->toArray();
            // will get drivers mobile nos
            $nos = User::whereIn('id', $driverIds)->pluck('mobile_no')->toArray();

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

            $bookingLogs = BookingLog::where('booking_id', $id)->get();

            foreach ( $bookingLogs as $index => $log ) {
                $log->driver_id = $driverIds[$index];
                $log->vehicle_id = $vehicleIds[$index];
                $log->save();
            }

        }

        if( $model->status == Booking::ALLOCATION_PENDING ) $model->status = Booking::ACCEPT;

        $model->vendor_id = request('vendor');
        $model->total_amount = request('amount');
        $model->save();

        return redirect()->route('admin.bookings.show', ['id' => $model->id])->withSuccess('Updated successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if(! $this->permission->edit() ) return;

        $model = $this->repository->find($id);

        $attrs = $request->only('customer_amount');

        $model = $this->repository->update($model, $attrs);

        $msg = str_replace('{BOOKING_ID}', $model->id, _t('revised_quote_post_negotiation_client_push_51'));
        $msg = str_replace('{AMOUNT}', $model->customer_amount, $msg);

        sendNotification($model->customer_id, [
            'booking_id'    => $model->id,
            'category'      => 'vendor_assign',
            'body'          => $msg
        ]);

        return $this->repository->redirectBackWithSuccess($this->repository->update_msg);

    }

    public function cancelBooking( $id ) {

        if(! $this->permission->edit() ) return;

        $model = $this->repository->find($id);
        
        if(!Booking::checkBeforeBookingLiveStatus($model->status)) return redirect()->back()->withErrors('Booking cannot be cancelled');

        $model->status = Booking::CANCEL;
        $model->save();
        
        $msg = str_replace('{BOOKING_ID}', '#'.$model->id, _t('booking_cancel_by_admin_62'));

        sendNotification([$model->customer_id, $model->vendor_id], [
            'booking_id'    => $model->id,
            'category'      => 'booking_cancel',
            'body'          => $msg
        ]);

        return $this->repository->redirectBackWithSuccess('This booking has been cancelled');

    }

    public function markBookingCancel( $id ) {

        $model = $this->repository->find($id);

        if( $model->status != Booking::PENDING ) return redirectToDashboard();

        $model->status = Booking::CANCEL;
        $model->save();

        $msg = str_replace('{BOOKING_ID}', '#'.$model->id, _t('booking_cancel_by_admin_62'));

        sendNotification([$model->customer_id], [
            'booking_id'    => $model->id,
            'category'      => 'booking_cancel',
            'body'          => $msg
        ]);

        return $this->repository->redirectBackWithSuccess('This booking has been cancelled');        

    }

}