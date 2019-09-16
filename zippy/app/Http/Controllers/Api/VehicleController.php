<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VehicleRepository;

class VehicleController extends ApiController {

    public $repository;
    public function __construct(
        VehicleRepository $repository

    ) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $rules =  [
            'vendor_id'     => 'required',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $collection = $this->repository->getCollection()->where('vendor_id', request('vendor_id'))->get();

        return $this->data($this->repository->parseCollection($collection), '', 'vehicle_details');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {

        $rules =  [
            'vendor_id'             => 'required|exists:users,id',
            'vehicle_type_id'       => 'required|exists:vehicle_types,id',
            // 'vehicle_category_id'   => 'required|exists:vehicle_categories,id',
            'registration_no'       => 'required|unique:vehicles,registration_no',
            // 'registration_pic'      => 'required|image',
            // 'image'                 => 'required|image',
            // 'owner_name'            => 'required',
            // 'owner_mobile'          => 'required|digits:10|numeric',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->save($this->repository->getAttrs());

        return $this->data($this->repository->parseModel($model), 'Created successfully', 'vehicle_details');

    }


    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update() {

        $rules =  [
            'vendor_id'     => 'required|exists:users,id',
            'vehicle_id'    => 'required|exists:vehicles,id',
            'owner_mobile'  => 'digits:10|numeric',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->find(request('vehicle_id'));

        $model = $this->repository->update($model);

        return $this->data($this->repository->parseModel($model), 'Updated successfully', 'vehicle_details');

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
            'vehicle_id' => 'required|exists:vehicles,id',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->find(request('vehicle_id'));

        $this->repository->delete($model);

        return $this->data([], 'vehicle removed', 'vehicle_details');

    }

}
