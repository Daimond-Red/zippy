<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Permissions\Permission;
use App\Basecode\Classes\Repositories\DriverNotificationRepository as Repository;
use App\User;
use App\AppNotification;

class DriverNotificationController extends BackendController {

    public $repository, $permission;

    public function __construct(Repository $repository, Permission $permission) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function index() {

    //     if(! $this->permission->index() ) return;
        
    //     $collection = AppNotification::with(['users' => function($q) {
    //         $q->where('role', User::DRIVER);
    //     }])->paginate(15);

    //     // dd($collection->toArray());
    //     return view($this->repository->viewIndex, [
    //         'collection' => $collection,
    //         'repository' => $this->repository
    //     ]);

    // }
    public function create() {

        if(! $this->permission->create() ) return;

        $collection = User::whereIn('role', [User::DRIVER]);
        $allUserIds = $collection->pluck('id')->toArray();
        $collection = $collection->paginate(30);

        return view($this->repository->viewCreate, [
            'repository'        => $this->repository,
            'collection'        => $collection,
            'allUserIds'        => $allUserIds,
        ]);

    }

}

