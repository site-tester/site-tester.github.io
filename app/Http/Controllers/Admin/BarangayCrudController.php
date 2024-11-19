<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BarangayRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BarangayCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BarangayCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Barangay::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/barangay');
        CRUD::setEntityNameStrings('barangay', 'barangays');
        // $this->crud->enableResponsiveTable();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.
        CRUD::orderBy('name','asc');

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Barangay Name'
        ]); 
        CRUD::addColumn([
            'name' => 'barangay_rep_id',
            'label' => 'Barangay Representative',
            'entity' => 'barangayRep', // Name of the relationship method in Barangay model
            'model' => 'App\Models\User', // Your User model
            'attribute' => 'name', // Displayed attribute from the user
            'pivot' => false,

        ]);


        CRUD::addColumn([
            'name' => 'location',
            'label' => 'Location'
        ]);

        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email',
            'entity' => 'barangayRep', // Name of the relationship method in Barangay model
            'model' => 'App\Models\User', // Your User model
            'attribute' => 'email', // Displayed attribute from the user
            'pivot' => false,

        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(BarangayRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.


        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::addField([
            'name' => 'name',
            'label' => 'Barangay Name',
            'type' => 'text',
        ]);

        // Adding the dropdown for barangay_rep_id
        CRUD::addField([
            'name' => 'barangay_rep_id',
            'label' => 'Barangay Representative',
            'type' => 'select',
            'entity' => 'barangayRep',
            'model' => 'App\Models\User',
            'attribute' => 'name',
            'attributes' => [
                'placeholder' => 'Select a representative',
            ],
            'options' => (function ($query) {
                return $query->whereHas('roles', function ($q) {
                    $q->where('name', 'Barangay Representative'); // Filter only users with this role
                })->get();
            })
        ]);
        CRUD::addField([
            'name' => 'location',
            'label' => 'Location',
            'type' => 'text',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


}
