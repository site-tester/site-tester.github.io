<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\User;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/users');
        CRUD::setEntityNameStrings('user', 'users');
    }

    protected function setupListOperation()
    {
        $this->crud->query->whereHas('roles', function ($query) {
            $query->where('name', 'Normal User'); // Adjust 'Normal User' to your exact role name
        });
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Name'
        ]);
        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email'
        ]);

        CRUD::addColumn([ // n-n relationship (with pivot table)
            'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
            'type'      => 'select_multiple',
            'name'      => 'roles', // the method that defines the relationship in your Model
            'entity'    => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => config('permission.models.role'), // foreign key model
        ]);

    }

    protected function setupCreateOperation()
    {
        // CRUD::setValidation(UserRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        CRUD::field('name')->validationRules('required|min:255');
        CRUD::field('email')->validationRules('required|email|unique:users,email');
        CRUD::field('password')->validationRules('required');
    }


    protected function setupUpdateOperation()
    {
        // $this->setupCreateOperation();
        CRUD::field('name')->validationRules('required|min:5');
        CRUD::field('email')->validationRules('required|email|unique:users,email,' . CRUD::getCurrentEntryId());
        CRUD::field('password')->hint('Type a password to change it.');

    }
}
