<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Permissions\Permission;
use App\Basecode\Classes\Repositories\AppNotificationRepository as Repository;
use App\User;

class AppNotificationController extends BackendController {

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
    public function create() {

        if(! $this->permission->create() ) return;

        $collection = $this->repository->getUserCollection()->whereIn('role', [User::CUSTOMER, User::VENDOR]);

        $allUserIds = $collection->pluck('id')->toArray();

        $collection = $collection->paginate(30);

        return view($this->repository->viewCreate, [
            'repository'        => $this->repository,
            'collection'        => $collection,
            'allUserIds'        => $allUserIds,
        ]);

    }

}
