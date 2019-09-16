<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\VendorRepository;
use App\Http\Controllers\Api\ApiController;

class TemplateController extends ApiController {

    public $vendorRepository;

    public function __construct( VendorRepository $vendorRepository ) {
        $this->vendorRepository = $vendorRepository;
    }

    public function err($msg) {
        return [
            'status'    => 0,
            'msg'       => $msg
        ];
    }

    public function success($msg) {
        return [
            'status'    => 1,
            'msg'       => $msg
        ];
    }

    public function getDriverVehicleDropdown() {

        $vehicleIds = $driverIds = ['' => 'Please select'];

        if( request('vendor_id') ) {

            $vendor = $this->vendorRepository->find(request('vendor_id'));

            $vehicleIds = $vendor->vehicles->pluck('registration_no', 'id');
            $driverIds = $vendor->drivers->pluck('email', 'id');

        }



        return view('admin.templates.getDriverVehicleDropdown', compact('driverIds', 'vehicleIds'));

    }

}
