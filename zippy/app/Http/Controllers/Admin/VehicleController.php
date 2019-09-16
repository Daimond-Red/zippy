<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VendorRepository;
use App\Basecode\Classes\Repositories\VehicleRepository;
use App\Basecode\Classes\Repositories\VehicleTypeRepository;
use App\Basecode\Classes\Repositories\VehicleCategoryRepository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class VehicleController extends BackendController {

    public $vendorRepository, $vehicleRepository, $vehicleTypeRepository, $vehicleCategoryRepository;

    public function __construct(
        VendorRepository $vendorRepository,
        VehicleRepository $vehicleRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        VehicleCategoryRepository $vehicleCategoryRepository,
        Permission $permission) {

        $this->vendorRepository = $vendorRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
        $this->vehicleRepository = $vehicleRepository;

    }

    public function index_vehicle($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        $collection = $this->vehicleRepository->getCollection()->where('vendor_id', $vendor->id)->get();

        return view($this->vehicleRepository->viewIndex, compact('collection', 'vendor'));

    }

    public function add_vehicle($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        $vehicletypes = $this->vehicleTypeRepository->getCollection()->pluck('title', 'id');
        $vehiclecategories = $this->vehicleCategoryRepository->getCollection()->pluck('title', 'id');

        return view($this->vehicleRepository->viewCreate, compact('vendor', 'vehicletypes', 'vehiclecategories'));
    }

    public function store_vehicle($vendor_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        request()->validate($this->vehicleRepository->storeValidateRules);

        $this->vehicleRepository->save(array_merge($this->vehicleRepository->getAttrs(), ['vendor_id' => $vendor_id]));

        return $this->vehicleRepository->redirectBackWithSuccess($this->vehicleRepository->create_msg);

    }

    public function edit_vehicle($vendor_id, $vehicle_id) {

        $vendor = $this->vendorRepository->find($vendor_id);

        $model = $this->vehicleRepository->find($vehicle_id);

        $vehicletypes = $this->vehicleTypeRepository->getCollection()->pluck('title', 'id');
        $vehiclecategories = $this->vehicleCategoryRepository->getCollection()->pluck('title', 'id');

        return view($this->vehicleRepository->viewEdit, compact('vendor', 'model', 'vehicletypes', 'vehiclecategories'));

    }

    public function update_vehicle($vendor_id, $vehicle_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->vehicleRepository->find($vehicle_id);

        $this->vehicleRepository->update($model);

        return $this->vendorRepository->redirectBackWithSuccess($this->vendorRepository->update_msg);

    }

    public function delete_vehicle($vendor_id, $vehicle_id) {

        $vendor = $this->vendorRepository->find($vendor_id);
        $model = $this->vehicleRepository->find($vehicle_id);

        $this->vehicleRepository->delete($model);

        return $this->vehicleRepository->redirectBackWithSuccess($this->vehicleRepository->delete_msg);
    }

}