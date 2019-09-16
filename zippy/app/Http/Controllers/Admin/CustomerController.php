<?php

namespace App\Http\Controllers\Admin;

use \App\ReviewRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\CustomerRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class CustomerController extends BackendController {

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

}
