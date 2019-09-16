<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Repositories\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VendorRepository as VendorRepository;
use App\Basecode\Classes\Repositories\DriverRepository as DriverRepository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class DriverController extends BackendController {

    public $vendorRepository, $driverRepository;

    public function __construct(
        VendorRepository $vendorRepository,
        DriverRepository $driverRepository,
        Permission $permission) {

        $this->vendorRepository = $vendorRepository;
        $this->driverRepository = $driverRepository;

    }

    public function index_driver($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        $collection = $this->driverRepository->getCollection()->where('vendor_id', $vendor->id)->get();

        return view($this->driverRepository->viewIndex, compact('collection', 'vendor'));

    }

    public function add_driver($vendor_id) {
        $vendor = $this->vendorRepository->find($vendor_id);
        return view($this->driverRepository->viewCreate, compact('vendor'));
    }

    public function store_driver($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        request()->validate($this->driverRepository->storeValidateRules);

        // $model = $this->driverRepository->getModel()->where([['mobile_no', request('mobile_no')], ['role', \App\User::DRIVER]])->first();

        // if($model) return $this->driverRepository->redirectBackWithError("This mobile number is already asign to another driver.");

        $attrs = array_merge($this->driverRepository->getAttrs(), ['vendor_id' => $vendor_id]);

        $this->driverRepository->save($attrs);

        return $this->driverRepository->redirectBackWithSuccess($this->driverRepository->create_msg);

    }

    public function edit_driver($vendor_id, $driver_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->driverRepository->find($driver_id);

        return view($this->driverRepository->viewEdit, compact('vendor', 'model'));

    }

    public function update_driver($vendor_id, $driver_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->driverRepository->find($driver_id);

        $this->driverRepository->update($model);

        return $this->vendorRepository->redirectBackWithSuccess($this->vendorRepository->update_msg);

    }

    public function delete_driver($vendor_id, $driver_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->driverRepository->find($driver_id);

        $this->driverRepository->delete($model);

        return $this->driverRepository->redirectBackWithSuccess($this->driverRepository->delete_msg);
    }

}
