<?php
/*
|--------------------------------------------------------------------------
| Newpixel\BlogCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Newpixel\BlogCRUD package.
|
*/
Route::group([
    'namespace' => 'Newpixel\BlogCRUD\app\Http\Controllers\Admin',
        'prefix' => config('backpack.base.route_prefix', 'admin') .'/'. config('blogcrud.route_prefix', 'blog'),
        'middleware' => ['web', backpack_middleware()],
    ], function () {
        CRUD::resource('article', 'BlogArticleCrudController');
        CRUD::resource('category', 'BlogCategoryCrudController');
        CRUD::resource('tag', 'BlogTagCrudController');

    });
