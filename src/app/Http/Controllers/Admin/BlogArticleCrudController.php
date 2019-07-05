<?php

namespace Newpixel\BlogCRUD\app\Http\Controllers\Admin;

use Backpack\CRUD\App\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use Newpixel\BlogCRUD\app\Http\Requests\BlogArticleRequest as StoreRequest;
use Newpixel\BlogCRUD\app\Http\Requests\BlogArticleRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class BlogArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BlogArticleCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Newpixel\BlogCRUD\app\Models\BlogArticle');
        $this->crud->setRoute(config('backpack.base.route_prefix') .'/'. config('blogcrud.route_prefix', 'blog') . '/article');
        $this->crud->setEntityNameStrings('Articol', 'Articole');

        // add asterisk for fields that are required in BlogArticleRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        // columns
        $this->crud->addColumns([
            [
               'name'  => 'name',
               'label' => 'Denumire'
            ],
            [
                'label'             => "Categorii",
                'type'              => 'select_multiple',
                'name'              => 'categories',
                'entity'            => 'categories',
                'attribute'         => 'name',
                'model'             => "Newpixel\BlogCRUD\app\Models\BlogCategory",
            ],
            [
                'name'              => 'status',
                'label'             => 'Status',
                'type'              => 'select_from_array',
                'options'           => $this->crud->model::$status,
                'allows_null'       => false,
                'allows_multiple'   => false,
                'tab'               => 'General',
                'wrapperAttributes' => ['class' => 'form-group col-md-2'],
            ],
            [
                'label'             => "Etichete",
                'type'              => 'select_multiple',
                'name'              => 'tags',
                'entity'            => 'tags',
                'attribute'         => 'name',
                'model'             => "Newpixel\BlogCRUD\app\Models\BlogTag",
            ],
            [
                'name'  => 'created_at',
                'label' => 'Adaugat la',
                'type'  => 'date',
            ],
        ]);

        // fields
        $this->crud->addFields(
            [
                [
                    'name'              => 'name',
                    'label'             => 'Titlu',
                    'type'              => 'text',
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-10'],
                ],
                [
                    'name'              => 'status',
                    'label'             => 'Status',
                    'type'              => 'select_from_array',
                    'options'           => $this->crud->model::$status,
                    'allows_null'       => false,
                    'allows_multiple'   => false,
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-2'],
                ],
                [
                    'label'             => "Categorii",
                    'type'              => 'select2_multiple',
                    'name'              => 'categories',
                    'entity'            => 'categories',
                    'attribute'         => 'name',
                    'model'             => 'Newpixel\BlogCRUD\app\Models\BlogCategory',
                    'pivot'             => true,
                    'select_all'        => false,
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'name'              => 'content',
                    'label'             => 'Detalii',
                    'type'              => 'wysiwyg',
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'label'             => "Etichete",
                    'type'              => 'select2_multiple',
                    'name'              => 'tags',
                    'entity'            => 'tags',
                    'attribute'         => 'name',
                    'model'             => 'Newpixel\BlogCRUD\app\Models\BlogTag',
                    'pivot'             => true,
                    'select_all'        => false,
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-12'],
                ],
                [
                    'name'     => 'title',
                    'label'    => "Meta Title",
                    'fake'     => true,
                    'store_in' => 'meta',
                    'tab'      => 'SEO'
                ],
                [
                    'name'     => 'description',
                    'label'    => "Meta Description",
                    'type'     => 'textarea',
                    'fake'     => true,
                    'store_in' => 'meta',
                    'tab'      => 'SEO'
                ],
                [
                    'name'     => 'keywords',
                    'label'    => 'Meta Keywords',
                    'fake'     => true,
                    'store_in' => 'meta',
                    'tab'      => 'SEO',
                ],
            ]
        );

        $this->crud->addFilter(
            [
                'type' => 'simple',
                'name' => 'trashed',
                'label'=> 'Sterse'
            ],
            false,
            function ($values) {
                $this->crud->query = $this->crud->query->onlyTrashed();
            }
        );

    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
