<?php

namespace App\Http\Controllers\Admin;

use App\Basecode\Classes\Permissions\Permission;
use App\Basecode\Classes\Repositories\PaymentTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentTypeController extends BackendController {

    public $repository, $permission;

    public function __construct(PaymentTypeRepository $repository, Permission $permission) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

}