<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\RequestDonationRequest;
use Carbon\Carbon;

/**
 * Class RequestDonationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RequestDonationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\RequestDonation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/request-donation');
        CRUD::setEntityNameStrings('Request Donation', 'Request Donations');

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
            // $this->crud->removeAllButtons();
            $this->crud->removeButton('update');
        }
        CRUD::setFromDb(); // set columns from db columns.

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
        CRUD::setValidation(RequestDonationRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        CRUD::addField([
            'name' => 'disaster_type',
            'label' => 'Disaster Type',
            'type' => 'select_from_array', // Use select2 for better UX
            'options' => [
                'Flood' => 'Flood',
                'Fire' => 'Fire',
                'Earthquake' => 'Earthquake',
            ],
            'allows_multiple' => false, // Set to true if you want to allow multiple selections
        ]);

        // Field for Barangay
        CRUD::addField([
            'name' => 'preffered_donation_type',
            'label' => 'Preffered Donation Type',
            'type' => 'select_from_array', // Use select2 for better UX
            'options' => [
                'Food' => 'Food',
                'NonFood' => 'Non Food',
                'Medical' => 'Medical',
            ],
            'allows_multiple' => false, // Set to true if you want to allow multiple selections
        ]);

        CRUD::addField([
            'name' => 'date_requested',
            'label' => 'Date Requested',
            'type' => 'date',
        ]);

        // Add hidden field for the barangay that the user represents
        $userBarangay = Barangay::where('barangay_rep_id', auth()->id())->first();
        if ($userBarangay) {
            CRUD::addField([
                'name' => 'barangay',
                'type' => 'hidden',
                'value' => $userBarangay->id,
            ]);
        }

        // Field for Status
        if (auth()->user()->hasRole('Municipal Admin')) {
            CRUD::addField([
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select_from_array',
                'options' => [
                    'Pending Approval' => 'Pending Approval',
                    'Approved' => 'Approved',
                ],
                'allows_multiple' => false,
            ]);
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
