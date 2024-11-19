<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Models\Barangay;
use App\Models\Item;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

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
        CRUD::setEntityNameStrings('inventory', 'inventories');
        $this->crud->addButtonFromView('bottom', 'print_button', 'print_button');
        // CRUD::addClause('orderBy', 'expiration_date', 'asc');
        CRUD::addClause('orderByRaw', 'expiration_date IS NULL, expiration_date ASC');

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setListView('vendor.backpack.crud.inventory_list');

        $this->data['overviewData'] = [
            'totalItems' => Item::count(),
            'totalFood' => Item::where('donation_type', 'Food')->count(),
            'totalNonFood' => Item::where('donation_type', 'NonFood')->count(),
            'totalMedical' => Item::where('donation_type', 'Medical')->count(),
        ];

        if (request()->has('type')) {
            $type = request('type');
            if ($type === 'food') {
                CRUD::addClause('where', 'donation_type', 'Food');
            }elseif ($type === 'nonfood') {
                CRUD::addClause('where', 'donation_type', 'NonFood');
            }elseif ($type === 'medical') {
                CRUD::addClause('where', 'donation_type', 'Medical');
            }
        }

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
        
        CRUD::addColumn([
            'name' => 'expiration_date',
            'label' => 'Expiration Date',
            'type' => 'date', // This specifies the date format
            'format' => 'YYYY-MM-DD' // Optional: Customize the date format if needed
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
        CRUD::addColumn([
            'name' => 'donation_id',
            'label' => 'Donation ID',
            'entity' => 'donation',
            'model' => 'App\Models\Donation',
            'attribute' => 'id',
            'pivot' => false,
        ]);

        return view(CRUD::getListView(), $this->data);
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
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        $fields = [
            [
                'name' => 'donation_id',
                'label' => 'Donation ID',
                'type' => 'text',
                'attributes' => [
                    'disabled'    => 'disabled',
                ]
            ],
            [
                'name' => 'barangay_id',
                'label' => 'Barangay',
                'entity' => 'barangay',
                'model' => 'App\Models\Barangay',
                'attribute' => 'name',
                'pivot' => false
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
            [
                'name' => 'quantity',
                'label' => 'Quantity',
                'type' => 'text',
            ],
            [
                'name' => 'expiration_date',
                'label' => 'Expiration Date',
                'type' => 'date',
                'attributes' => [
                    'min'    => Carbon::now()->format('Y-m-d'),
                ]
            ],
            [
                'name' => 'condition',
                'label' => 'Condition',
                'type' => 'text',
            ],

            // Add other fields here as needed


        ];

        foreach ($fields as $field) {
            // Check if the field has a value in the database
            if ($this->crud->getCurrentEntry()->{$field['name']} !== null) {
                CRUD::addField($field);
            }
        }
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
