<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barangay;
use App\Models\RequestDonation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Requests\RequestDonationRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            $this->crud->query->orderByRaw("
                CASE
                    WHEN status = 'Pending Approval' THEN 1
                    ELSE 2
                END
            ")->orderBy('date_requested', 'desc');
        }
        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'custom_html',
            'value' => function ($entry) {
                // Check if there is an unread notification related to this donation
                $unreadNotification = auth()->user()
                    ->unreadNotifications()
                    ->where('data->notification_to', 'Admin Request Approval Tab')
                    ->where('data->barangay_id', $entry->id)
                    ->where('data->request_status', 'Pending Approval')
                    ->exists();

                // Add the "new" badge if unread
                if ($unreadNotification) {
                    return $entry->id . ($unreadNotification ? ' <span class="badge bg-success">New</span>' : '');
                }

                return $entry->id;
            }

        ]);
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
                return '<a href="' . backpack_url('disaster-report-verification/' . $entry->id . '/show') . '" class="btn btn-info">View Disaster Form</a>';
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
                    $checkButton .= 'style="pointer-events: none;">';
                    $xButton .= 'disabled style="background-color: #ccc; border-color: #ccc;">'; // Grey out X button
                } elseif ($entry->status == 'Rejected') {
                    // If the status is Rejected, show the X button (colored) and disable the check button
                    $checkButton .= 'disabled style="background-color: #ccc; border-color: #ccc;">'; // Grey out check button
                    $xButton .= 'style="pointer-events: none;">';
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
        $entry = $this->crud->getCurrentEntry();
        if ($entry) {
            Auth::user()->unreadNotifications()
                ->where('data->notification_to', 'Admin Request Approval Tab')
                ->where('data->request_status', 'Pending Approval')
                ->where('data->barangay_id', $entry->id)
                // ->where('data->donation_request_id', $id)
                ->update(['read_at' => now()]);
        }
        $this->crud->removeAllButtons();
        $this->crud->setColumns([
            [
                'name' => 'status',
                'label' => 'Status',
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
                        if ($column['text'] == 'Verified') {
                            return 'badge text-bg-success'; // Green indicates approval
                        }
                        if ($column['text'] == 'Rejected') {
                            return 'badge text-bg-secondary'; // Yellow indicates a warning
                        }
                        return 'badge badge-default';
                    },
                ],
                'type' => 'closure',
                'function' => function ($entry) {
                    $value = '';
                    if ($entry->status == 'Approved') {
                        $value = 'Verified';
                    }

                    if ($entry->status == 'Pending Approval') {
                        $value = 'Pending Approval';
                    }

                    return $value;
                },
            ],
            [
                'name' => 'reported_by',
                'label' => 'Reported By',
            ],
            [
                'name' => 'date_requested',
                'label' => 'Date Requested',
                'type' => 'date',
            ],
            [
                'name' => 'incident_date',
                'label' => 'Incident Date',
                'type' => 'date',
            ],
            [
                'name' => 'incident_time',
                'label' => 'Incident Time',
                'type' => 'time',
                'format' => 'H:mm A'
            ],
            [
                'name' => 'barangay_id',
                'label' => 'Barangay',
                'entity' => 'barangay',
                'model' => 'App\Models\Barangay',
                'attribute' => 'name',
            ],
            [
                'name' => 'exact_location',
                'label' => 'Exact Location',
            ],
            [
                'name' => 'preffered_donation_type',
                'label' => 'Donation Type',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $rawValue = $entry->preffered_donation_type;
                    $rawValue = stripslashes($rawValue);
                    $cleanValue = trim($rawValue, '"');
                    $decoded = json_decode($cleanValue, true);
                    $formatted = array_map('ucfirst', $decoded);
                    return implode(', ', $formatted);

                },
            ],
            [
                'name' => 'disaster_type',
                'label' => 'Disaster Type',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $rawValue = $entry->disaster_type;
                    $rawValue = stripslashes($rawValue);
                    $cleanValue = trim($rawValue, '"');
                    $decoded = json_decode($cleanValue, true);
                    // Apply ucfirst to each item
                    $formatted = array_map('ucfirst', $decoded);
                    // If not JSON, return as is (with formatting)
                    return implode(', ', $formatted);
                },
            ],
            [
                'name' => 'caused_by',
                'label' => 'Caused By',
            ],
            [
                'name' => 'affected',
                'label' => 'Affected',
                'type' => 'custom_html',
                'value' => function ($entry) {

                    $value = "<table class='table table-bordered' >";
                    if ($entry->affected_family) {
                        $value .= "
                            <tr>
                                <td class='col-3 fw-bold'>Family:</td>
                                <td>" . $entry->affected_family . "</td>
                            </tr>
                            ";
                    }

                    if ($entry->affected_person) {
                        $value .= "
                            <tr>
                                <td class='fw-bold'>Person:</td>
                                <td>" . $entry->affected_person . "</td>
                            </tr>
                            ";
                    }

                    $value .= "</table>";


                    return $value;
                },
            ],
            [
                'name' => 'immediate_needs',
                'label' => 'Immediate Needs',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $value = "<table class='table table-bordered' >";
                    if ($entry->immediate_needs_food) {
                        $value .= "
                            <tr>
                                <td class='col-3 fw-bold'>Food:</td>
                                <td>" . $entry->immediate_needs_food . "</td>
                            </tr>
                            ";
                    }
                    if ($entry->immediate_needs_nonfood) {
                        $value .= "
                            <tr>
                                <td class='fw-bold'>Non-Food:</td>
                                <td>" . $entry->immediate_needs_nonfood . "</td>
                            </tr>
                            ";
                    }
                    if ($entry->immediate_needs_medicine) {
                        $value .= "
                            <tr>
                                <td class='fw-bold'> Medical Supplies: </td>
                                <td>" . $entry->immediate_needs_medicine . "</td>
                            </tr>
                            ";
                    }
                    $value .= "</table>";
                    return $value;
                },
            ],
            [
                'name' => 'attachments',
                'label' => 'Attachments',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $rawValue = $entry->attachments;
                    $rawValue = stripslashes($rawValue);
                    $cleanValue = trim($rawValue, '"');
                    $decoded = json_decode($cleanValue, true);

                    $value = "<div class='row'>";
                    foreach ($decoded as $img_path) {
                        $value .= " <div class='col-auto'>
                        <a href='/storage/app/public/{$img_path}' data-fancybox='gallery'
                            data-caption='{ $img_path }'>
                            <img src='/storage/app/public/{$img_path}' height='100' />
                        </a>
                        </div>";
                    }

                    $value .= "</div>";
                    return $value;
                },
            ],

        ]);

    }

    // Custom Function
    public function updateStatus(Request $request, $id)
    {
        $requestId = $this->crud->getCurrentEntry();
        if ($requestId) {
            Auth::user()->unreadNotifications()
                ->where('data->notification_to', 'Admin Request Approval Tab')
                ->where('data->request_status', 'Pending Approval')
                ->where('data->barangay_id', $requestId->id)
                // ->where('data->donation_request_id', $id)
                ->update(['read_at' => now()]);
        }

        $entry = RequestDonation::find($id);

        // Fetch the maximum values dynamically
        $maxFamilies = RequestDonation::max('affected_family');
        $maxPersons = RequestDonation::max('affected_person');

        $requestDonation = RequestDonation::all();

        if ($entry) {
            if ($request->status === 'Approved') {
                foreach ($requestDonation as $item) {
                    $vulnerability = $this->calculateVulnerability(
                        $item->affected_family,
                        $item->affected_person,
                        $maxFamilies,
                        $maxPersons
                    );

                    $item->vulnerability = $vulnerability;
                    $item->save();
                }
            }

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

    /**
     * Calculate vulnerability based on affected families and persons.
     */
    private function calculateVulnerability($affectedFamilies, $affectedPersons, $maxFamilies, $maxPersons)
    {
        // Weights for computation
        $weightFamilies = 0.6;
        $weightPersons = 0.4;

        // Normalize values
        $scoreFamilies = $affectedFamilies / $maxFamilies;
        $scorePersons = $affectedPersons / $maxPersons;

        // Compute vulnerability score
        $vulnerabilityScore = ($scoreFamilies * $weightFamilies) + ($scorePersons * $weightPersons);

        // Determine vulnerability level
        if ($vulnerabilityScore > 0.7) {
            return 'High';
        } elseif ($vulnerabilityScore >= 0.3 && $vulnerabilityScore <= 0.7) {
            return 'Moderate';
        } else {
            return 'Low';
        }
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
