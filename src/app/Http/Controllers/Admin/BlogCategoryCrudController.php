<?php

namespace Newpixel\BlogCRUD\app\Http\Controllers\Admin;

use Backpack\CRUD\App\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use Newpixel\BlogCRUD\app\Http\Requests\BlogCategoryRequest as StoreRequest;
use Newpixel\BlogCRUD\app\Http\Requests\BlogCategoryRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Newpixel\BlogCRUD\app\Models\BlogCategory;

/**
 * Class BlogCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BlogCategoryCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Newpixel\BlogCRUD\app\Models\BlogCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') .'/'. config('blogcrud.route_prefix', 'blog') . '/category');
        $this->crud->setEntityNameStrings('Categorie', 'Categorii');
        $this->crud->enableReorder('name', 0);
        $this->crud->allowAccess('reorder', 1);

        // add asterisk for fields that are required in BlogCategoryRequest
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
               'label'     => "Parinte",
               'type'      => "select",
               'name'      => 'parent_category_id',
               'entity'    => 'parent',
               'attribute' => "name",
               'model'     => "Newpixel\BlogCRUD\app\Models\Category",
            ],
            [
               'name'    => 'active',
               'label'   => 'Activ',
               'type'    => 'boolean',
               'options' => [0 => 'Nu', 1 => 'Da']
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
                    'label'             => 'Denumire',
                    'type'              => 'text',
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-7'],
                ],
                [
                    'name'              => 'parent_id',
                    'label'             => "Categorie parinte",
                    'type'              => 'select_from_array',
                    'options'           => BlogCategory::AllParent()->pluck('name', 'id')->toArray(),
                    'allows_null'       => true,
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'              => 'active',
                    'label'             => 'Activ',
                    'type'              => 'radio',
                    'options'           => [0 => 'Nu', 1 => 'Da'],
                    'inline'            => true,
                    'tab'               => 'General',
                    'wrapperAttributes' => ['class' => 'form-group col-md-2'],
                ],
                [
                    'name'              => 'details',
                    'label'             => 'Detalii',
                    'type'              => 'wysiwyg',
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
            false, function ($values) {
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
