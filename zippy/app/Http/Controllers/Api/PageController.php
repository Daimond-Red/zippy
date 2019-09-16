<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\PageRepository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class PageController extends ApiController {

    public $repository;
    public $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    public function index(){
        $rules =  [
            'slug' => 'required|exists:pages,slug',
        ];

        if ( $error = $this->cvalidate($rules) ) return $this->error($error, $error->first());

        $model = $this->repository->getCollection()->first();

        return $this->data($this->repository->parseModel($model), '', 'page');
    }

}
