<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Permissions\Permission;
use App\Basecode\Classes\Repositories\BookingNotificationRepository as Repository;
use App\User;

class BookingNotificationController extends BackendController {

    public $repository, $permission;

    public function __construct(Repository $repository, Permission $permission) {
        $this->repository = $repository;
        $this->permission = $permission;
    }
}