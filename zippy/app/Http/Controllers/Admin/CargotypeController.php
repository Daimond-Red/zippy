<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Basecode\Classes\Repositories\CargoTypeRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class CargotypeController extends BackendController {

    public $repository;
    public $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

}
