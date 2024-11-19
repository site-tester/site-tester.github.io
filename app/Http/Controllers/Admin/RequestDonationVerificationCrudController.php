<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use App\Models\RequestDonation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\RequestDonationRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Class RequestDonationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RequestDonationVerificationCrudController extends CrudController
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
        CRUD::setModel(RequestDonation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/disaster-report-verification');
        CRUD::setEntityNameStrings('Disaster Report Verification', 'Disaster Reports Verification');

        // if (auth()->user()->hasRole('Municipal Admin')) {
        //     $this->crud->denyAccess(['create']);
        // }

    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (auth()->user()->hasRole('Municipal Admin')) {
            $this->crud->removeAllButtons();
            // $this->crud->removeButton('update');
        }
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Date Reported',
            'type' => 'date',
            'format' => 'MMM-DD-YYYY',
        ]);
        CRUD::addColumn([
            'name' => 'barangay_id', // The actual column is named barangay
            'label' => 'Barangay',
            // 'type' => 'relationship',
            'entity' => 'barangay', // relationship is named barangay
            'attribute' => 'name',
            'model' => 'App\Models\Barangay',
        ]);
        CRUD::addColumn([
            'name' => 'disaster_report',
            'label' => 'Disaster Report',
            'type' => 'custom_html',
            'value' => function ($entry) {
                // Link to the preview route for this entry
                return '<a href="' . backpack_url('disaster-report-verification/' . $entry->id . '/show') . '" class="btn btn-info">View Report</a>';
            },
            'escaped' => false,  // Ensure the HTML is not escaped
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Verification',
            'type' => 'custom_html',
            'value' => function ($entry) {
                // Ensure the $entry is not null and the status is set
                if (!$entry) {
                    return ''; // Return an empty string or default HTML
                }

                // Define the button styles based on the current status
                $checkButton = '<button class="btn btn-success btn-lg" onclick="updateStatus(' . $entry->id . ', \'Approved\')" ';
                $xButton = '<button class="btn btn-danger btn-lg" onclick="updateStatus(' . $entry->id . ', \'Rejected\')" ';

                // Check the current status of the entry and adjust the buttons accordingly
                if ($entry->status == 'Pending Approval') {
                    // Both buttons are clickable if the status is Pending Approval
                    $checkButton .= '>';
                    $xButton .= '>';
                } elseif ($entry->status == 'Approved') {
                    // If the status is Approved, show the check button (colored) and disable the X button
                    $checkButton .= 'disabled>';
                    $xButton .= 'disabled style="background-color: #ccc; border-color: #ccc;">'; // Grey out X button
                } elseif ($entry->status == 'Rejected') {
                    // If the status is Rejected, show the X button (colored) and disable the check button
                    $checkButton .= 'disabled style="background-color: #ccc; border-color: #ccc;">'; // Grey out check button
                    $xButton .= 'disabled>';
                }

                // Add the icon HTML to both buttons
                $checkButton .= '<i class="la la-check-circle"></i></button>';
                $xButton .= '<i class="la la-times-circle"></i></button>';

                // Return both buttons
                return $checkButton . ' ' . $xButton;
            },
            'escaped' => false,
        ]);
        // CRUD::setFromDb(); // set columns from db columns.

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

    public function setupShowOperation()
    {
        $this->crud->removeAllButtons();
        $this->crud->setColumns([
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'text',
                'wrapper' => [
                    'element' => 'span',
                    'class' => function ($crud, $column, $entry, $related_key) {
                        // Determine the badge class based on the status value
                        if ($column['text'] == 'Pending Approval') {
                            return 'badge text-bg-warning'; // Yellow indicates awaiting action
                        }
                        if ($column['text'] == 'Approved') {
                            return 'badge text-bg-success'; // Green indicates approval
                        }
                        if ($column['text'] == 'Rejected') {
                            return 'badge text-bg-secondary'; // Yellow indicates a warning
                        }
                        return 'badge badge-default';
                    },
                ],
            ],
            [
                'name' => 'barangay_id',
                'label' => 'Barangay',
                'entity' => 'barangay',
                'model' => 'App\Models\Barangay',
                'attribute' => 'name',
            ],
            [
                'name' => 'disaster_type',
                'label' => 'Disaster Type',
            ],
            [
                'name' => 'preffered_donation_type',
                'label' => 'Donation Type',
            ],
            [
                'name' => 'immediate_needs',
                'label' => 'Immediate Needs',
            ],
            [
                'name' => 'date_requested',
                'label' => 'Date Requested',
                'type' => 'date',
            ],

            // Add other fields you want to display
        ]);

    }

    // Custom Function
    public function updateStatus(Request $request, $id)
    {
        $entry = RequestDonation::find($id);

        if ($entry) {
            $entry->status = $request->status;
            $entry->save();

            return response()->json([
                'success' => true,
                'message' => 'Donation Request is' . $entry->status,
                'status' => $entry->status
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Donation request not found.'
        ]);
    }


    public function disasterRequestModal($id)
    {
        $report = RequestDonation::findOrFail($id);

        // Return HTML content for the modal
        return response()->json([
            'html' => view('modals.disasterRequestModal', compact('report'))->render(),
        ]);
    }

}
