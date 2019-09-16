<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\ReviewRating;
use App\ServiceableArea;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\VendorRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class VendorController extends BackendController {

    public $repository;
    public $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function index() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository->getPaginated(15);

        $ratings = ReviewRating::select('rated_id', \DB::raw(' round(avg(rating)) as avg'))->groupBy('rated_id')->pluck('avg', 'rated_id');

        return view($this->repository->viewIndex, [
            'collection' => $collection,
            'repository' => $this->repository,
            'ratings'   => $ratings
        ]);

    }

    public function search() {

        $data = [];

        $collection = $this->repository->getCollection()->where(function ($q){
            $q->orWhere('first_name', 'like', '%'. request('q'). '%');
            $q->orWhere('last_name', 'like', '%'. request('q'). '%');
            $q->orWhere('email', 'like', '%'. request('q'). '%');
        })->take(50)->get(['id', 'first_name', 'last_name', 'email']);

        foreach($collection as $model) $data['items'][] = ['id' => $model->id, 'text' => $model->first_name. ' '. $model->last_name. ' ('. $model->email. ')' ];

        return $data;

    }

    public function indexAreas($id) {

        if(! $this->permission->edit() ) return;

        $areas = ServiceableArea::where('user_id', $id)->orderBy('base_state_id')->get(['base_state_id', 'drop_state_id']);

        $collection = [];

        foreach( $areas as $area ) $collection[$area->base_state_id][] = $area->drop_state_id;

        $vendorId = $id;

        return view('admin.vendors.serviceableAreas.index', compact('collection', 'vendorId'));

    }

    public function storeAreas( $id ) {

        \request()->validate([ 'base_location' => 'required', 'drop_locations' => 'required' ]);

        $dropStateIds = State::whereIn('id', \request('drop_locations'))->pluck('id');

        $availableDropStateIds = ServiceableArea::where('user_id', $id)->where('base_city_id', \request('base_location'))->pluck('drop_state_id');

        $arr = [];

        foreach ( $dropStateIds as $dropStateId ) {

            if( in_array($dropStateId, $availableDropStateIds->toArray()) ) continue;

            $arr[] = [
                'user_id'           => $id,
                'base_state_id'     => \request('base_location'),
                'drop_state_id'     => $dropStateId,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s')
            ];

        }


        if(! blank($arr) ) ServiceableArea::insert($arr);

        return $this->repository->redirectBackWithSuccess('Added Successfully');

    }

    public function updateAreas( $id, $userId ) {

        \request()->validate(['drop_locations' => 'required']);

        $this->repository->updateServiceableAreas($userId, $id, \request('drop_locations'));

        return $this->repository->redirectBackWithSuccess('Saved Successfully');

    }

    public function deleteAreas( $id ) {

        ServiceableArea::where('base_state_id', $id)->delete();

        return $this->repository->redirectBackWithSuccess('Deleted Successfully');

    }

}