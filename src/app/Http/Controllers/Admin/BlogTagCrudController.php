<?php

namespace Newpixel\BlogCRUD\app\Http\Controllers\Admin;

use Backpack\CRUD\App\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use Newpixel\BlogCRUD\app\Http\Requests\BlogTagRequest as StoreRequest;
use Newpixel\BlogCRUD\app\Http\Requests\BlogTagRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class BlogTagCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BlogTagCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Newpixel\BlogCRUD\app\Models\BlogTag');
        $this->crud->setRoute(config('backpack.base.route_prefix') .'/'. config('blogcrud.route_prefix', 'blog') . '/tag');
        $this->crud->setEntityNameStrings('Eticheta', 'Etichete');

        // add asterisk for fields that are required in BlogTagRequest
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
                    'wrapperAttributes' => ['class' => 'form-group col-md-10'],
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
