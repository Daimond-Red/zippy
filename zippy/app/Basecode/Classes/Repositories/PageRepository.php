<?php

namespace App\Basecode\Classes\Repositories;

class PageRepository extends Repository {

    public $model = '\App\Page';

    public $viewIndex = 'admin.pages.index';
    public $viewCreate = 'admin.pages.create';
    public $viewEdit = 'admin.pages.edit';
    public $viewShow = 'admin.pages.show';

    public $storeValidateRules = [
        'title' => 'required',
        'slug'  => 'unique:pages,slug',
    ];

    public $updateValidateRules = [
        'title' => 'required',
    ];

    public function getAttrs() {

        $attrs = parent::getAttrs();
        if(!request('slug')) $attrs['slug'] = str_slug(request('title'), '-');
        return $attrs;

    }

    public function getCollection() {
        $model = new $this->model;
        $model = $model->orderBy('created_at', 'desc');

        $whereLikefields = ['title', 'slug' ];

        foreach ($whereLikefields as $field) {
            if( $value = request($field) ) $model = $model->where($field, 'like', '%'.$value.'%');
        }

        return $model;
    }

}