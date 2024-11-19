<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DisasterReportRequest;
use App\Models\Barangay;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class DisasterReportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DisasterReportCrudController extends CrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix') . '/disaster-request');
        CRUD::setEntityNameStrings('Disaster Request', 'Disaster Requests');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::addClause('where', 'status', 'Approved');
        CRUD::setOperationSetting('showEntryCount', false);
        CRUD::setEntityNameStrings('Active Disaster Request', 'Active Disaster Requests');
        $this->crud->removeButton('create');

         CRUD::addColumn([
            'name' => 'barangay_id', // The actual field in your database (foreign key)
            'label' => 'Barangay', // The label you want to display in the column
            // 'type' => 'text', // Define it as a select field
            'entity' => 'barangay', // Define the relationship
            'attribute' => 'name', // The field from the related model (Barangay) to display

        ]);
        CRUD::addColumn([
            'name' => 'preffered_donation_type',
            'label' => 'Donation Type',
        ]);
        CRUD::addColumn([
            'name' => 'disaster_type',
            'label' => 'Disaster Type',
        ]);
        CRUD::addColumn([
            'name' => 'date_requested',
            'label' => 'Date Requested',
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'text',
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    // Determine the badge class based on the status value
                    if ($column['text'] == 'Approved') {
                        return 'badge text-bg-success'; // Green indicates approval
                    }
                    return 'badge badge-default';
                },
            ],
        ]);

        // CRUD::setFromDb(); // set columns from db columns.

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
        $this->data['breadcrumbs'] = [
            // trans('backpack::crud.admin') => backpack_url('dashboard'),
            trans('backpack::base.dashboard') => backpack_url('dashboard'),
            'Disaster Report' => false,
            'Create Form' => false,
        ];
        $this->crud->setSubheading('Create Form');
        $this->crud->denyAccess(['list', 'delete']);
        CRUD::addSaveAction([
            'name' => 'save_and_dashboard',
            'visible' => function ($crud) {
                return true;
            },
            'button_text' => 'Send Disaster Request',
            'redirect' => function ($crud, $request, $itemId) {
                return url('/admin/dashboard');
            },
        ]);
        CRUD::removeSaveActions(['save_and_new', 'save_and_preview']);
        $this->crud->setOperationSetting('showCancelButton', false);

        $this->crud->setCreateView('vendor.backpack.ui.addDisasterReport');

        // CRUD::setListView('vendor.backpack.ui.addDisasterReport');
        CRUD::setValidation(DisasterReportRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        CRUD::addField([
            'name' => 'header',
            'type' => 'custom_html',
            'value' => '<h3 class="mb-0 pb-0">Barangay Details</h3>',
        ]);

        CRUD::addField([
            'name' => 'barangay_id',
            'label' => 'Barangay Name',
            'entity' => 'barangay',
            'model' => 'App\Models\Barangay',
            'attribute' => 'name',
            'pivot' => false,
        ]);

        CRUD::addField([
            'name' => 'disaster_type',
            'label' => 'Disaster Type',
            'type' => 'select_from_array',
            'options' => [
                'Flood' => 'Flood',
                'Fire' => 'Fire',
                'Earthquake' => 'Earthquake',
            ],
            'attributes' => [
                'placeholder' => 'Select Disaster Type',
            ],
            'allows_multiple' => false, // Set to true if you want to allow multiple selections
        ]);

        CRUD::addField([
            'name' => 'separator',
            'type' => 'custom_html',
            'value' => '<hr>',
        ]);

        CRUD::addField([
            'name' => 'header2',
            'type' => 'custom_html',
            'value' => '<h3 class="mb-0 pb-0">Disaster Details</h3>',
        ]);
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
        // $userBarangay = Barangay::where('barangay_rep_id', auth()->id())->first();
        // if ($userBarangay) {
        //     CRUD::addField([
        //         'name' => 'barangay',
        //         'type' => 'hidden',
        //         'value' => $userBarangay->id,
        //     ]);
        // }

        // return view(CRUD::getListView(), $this->data);


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
