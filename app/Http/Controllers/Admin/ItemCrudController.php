<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Models\Barangay;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ItemCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Item::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/item');
        CRUD::setEntityNameStrings('item', 'items');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (auth()->user()->hasRole('Barangay Representative')) {
            // Get the barangay_id of the authenticated user
            $barangayRepId = auth()->user()->id;
            $barangayId = Barangay::where('barangay_rep_id', $barangayRepId)->first();
            // dd($barangayId);
            // Add a filter clause to only show donations related to the user's barangay
            CRUD::addClause('where', 'barangay_id', $barangayId->id);
        }

        // CRUD::setFromDb(); // set columns from db columns.

        CRUD::addColumn([
            'name' => 'donation_id',
            'label' => 'Donation ID',
            'entity' => 'donation',
            'model' => 'App\Models\Donation',
            'attribute' => 'id',
            'pivot' => false,
        ]);

        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Item',
        ]);

        CRUD::addColumn([
            'name' => 'quantity',
            'label' => 'Quantity',
        ]);
        // CRUD::addColumn([
        //     'name' => 'donation_id',
        //     'label' => 'Donor Name',
        //     'type' => 'relationship',
        //     'entity' => 'donation',
        //     'attribute' => 'donor.email',
        //     'model' => 'App\Models\User',
        //     'pivot' => false,
        // ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ItemRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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