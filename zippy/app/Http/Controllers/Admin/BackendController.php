<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Basecode\Classes\Repositories\Repository as Repository;
use App\Basecode\Classes\Permissions\Permission as Permission;

class BackendController extends Controller
{
    public $repository, $permission;

    public function __construct(
        Repository $repository,
        Permission $permission
    ) {
        $this->repository = $repository;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        if(! $this->permission->index() ) return;

        $collection = $this->repository->getPaginated(15);

        return view($this->repository->viewIndex, [
            'collection' => $collection,
            'repository' => $this->repository
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if(! $this->permission->create() ) return;

        return view($this->repository->viewCreate, [
            'repository' => $this->repository
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        if(! $this->permission->create() ) return;

        $request->validate($this->repository->storeValidateRules);

        $this->repository->save($this->repository->getAttrs());

        return $this->repository->redirectBackWithSuccess($this->repository->create_msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        if(! $this->permission->show() ) return;

        $model = $this->repository->find($id);

        return view($this->repository->viewShow, [
            'model'         => $model,
            'repository'    => $this->repository
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        if(! $this->permission->edit() ) return;

        $model = $this->repository->find($id);

        return view($this->repository->viewEdit, [
            'model'         => $model,
            'repository'    => $this->repository
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if(! $this->permission->edit() ) return;

        $model = $this->repository->find($id);

        $this->repository->update($model);

        return $this->repository->redirectBackWithSuccess($this->repository->update_msg);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        if(! $this->permission->destroy() ) return;

        $model = $this->repository->find($id);

        $this->repository->delete($model);

        return $this->repository->redirectBackWithSuccess($this->repository->delete_msg);

    }

}