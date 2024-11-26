<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\Item;
use App\Models\RequestDonation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RequestDonationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransferDonationController extends CrudController
{
    //
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
        CRUD::setRoute(config('backpack.base.route_prefix') . '/donation-transfer');
        CRUD::setEntityNameStrings('Transfer Disaster Request', 'Transfer Disaster Requests');
        $this->crud->denyAccess(['create']);


    }
    public function viewTransferPage()
    {
        $donationRequests = RequestDonation::where('status', 'Received')->get(); // Get approved disaster requests
        return view('vendor.backpack.ui.transferDonations', compact('donationRequests'));
    }

    protected function setupListOperation()
    {

        CRUD::addClause('where', 'barangay_id', '!=', Auth::id());
        $this->data['breadcrumbs'] = [
            trans('backpack::base.dashboard') => backpack_url('dashboard'),
            'Transfer Disaster Requests' => false,
            'List' => false,
        ];


        CRUD::addClause('where', 'status', 'Approved');
        CRUD::setOperationSetting('showEntryCount', false);
        CRUD::setEntityNameStrings('Transfer Disaster Request', 'Transfer Disaster Requests');
        $this->crud->removeButtons(['create', 'update', 'delete']);

        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Date Requested',
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
        ]);
        CRUD::addColumn([
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
                'name' => 'vulnerability',
                'label' => 'Vulnerability',
                'type' => 'text',
                'wrapper' => [
                    'element' => 'span',
                    'class' => function ($crud, $column, $entry, $related_key) {
                        // Determine the badge class based on the status value
                        if ($column['text'] == 'High') {
                            return 'badge text-bg-danger'; // Yellow indicates awaiting action
                        }
                        if ($column['text'] == 'Moderate') {
                            return 'badge text-bg-warning'; // Green indicates approval
                        }
                        if ($column['text'] == 'Low') {
                            return 'badge text-bg-success'; // Yellow indicates a warning
                        }
                        return 'badge badge-default';
                    },
                ],
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
                        <a href='/storage/{$img_path}' data-fancybox='gallery'
                            data-caption='{ $img_path }'>
                            <img src='/storage/{$img_path}' height='100' />
                        </a>
                        </div>";
                    }

                    $value .= "</div>";
                    return $value;
                },
            ],
            [
                'name' => 'transfered_by',
                'label' => 'Transfer',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $barangay = Barangay::where('barangay_rep_id', Auth::id())->first();

                    // Get all donations for the barangay with "Received" status
                    $donations = Donation::where('barangay_id', $barangay->id)
                        ->where('status', 'Received')
                        ->get();

                    // Collect all items associated with these donations
                    $donationItems = Item::whereIn('donation_id', $donations->pluck('id'))->get();

                    // Start building the custom HTML
                    $value = "<div class='row'>";
                    $value .= "
                            <div class='col-12'>
                                <h3>Recieved Donations</h3>
                            </div>
                            <div class='col-12 mb-3'>
                                <select class='form-control' name='donation_item_id'>
                                    <option >
                                ";

                    // Populate the dropdown with donation items
                    foreach ($donationItems as $item) {
                        $value .= "<option value='{$item->id}'>{$item->name} - {$item->quantity} from Donation ID: {$item->donation_id}</option>";
                    }

                    $value .= "</select>
                            </div>
                            <div class='col-12'>
                                <h3>Transfered By:</h3>
                            </div>
                            <div class='col-12'>
                                <input class='form-control' name='transferedBy' placeholder='Enter Transferer Name'>
                            </div>
                            <div class='col-12 mt-3'>
                                <button type='button' class='btn btn-primary' onclick='transferDonation()'>Transfer Donation</button>
                            </div>";
                    $value .= "</div>";
                    return $value;
                },
            ],

        ]);

    }


}
