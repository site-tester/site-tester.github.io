<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DisasterReportRequest;
use App\Models\Barangay;
use App\Models\DisasterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

/**
 * Class DisasterReportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DisasterReportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore;
    }
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
        CRUD::addClause('where', 'barangay_id', auth()->user()->id);
        CRUD::setOperationSetting('showEntryCount', false);
        CRUD::setEntityNameStrings('Active Disaster Request', 'Active Disaster Requests');
        $this->crud->removeButtons(['create','update']);

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
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    // Determine the badge class based on the status value
                    if ($column['text'] == 'Approved') {
                        return 'badge text-bg-success'; // Green indicates approval
                    }
                    if ($column['text'] == 'Verified') {
                        return 'badge text-bg-success'; // Green indicates approval
                    }
                    return 'badge badge-default';
                },
            ],
            'type' => 'closure',
                'function' => function ($entry) {
                    return $entry->status == 'Approved' ? 'Verified' : '';
                },
        ]);
        CRUD::addButtonFromView('line', 'delete', 'custom_delete_button');

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
        CRUD::removeSaveActions(['save_and_new', 'save_and_edit', 'save_and_preview']);
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
            'value' => '<h3 class="mb-0 pb-0">Disaster Request - Create Form</h3>',
            'wrapper' => [
                'class' => 'mb-0',
            ],
        ]);

        CRUD::addField([
            'name' => 'table_start',
            'type' => 'custom_html',
            'value' => '<table class="table table-responsive table-bordered">',
            'escaped' => false,
            'wrapper' => false,
        ]);

        CRUD::addField([
            'name' => 'reported_by',
            'label' => 'Reported By',
            'type' => 'add_disaster_report_text',
        ]);

        CRUD::addField([
            'name' => 'incident_date',
            'label' => 'Date of Incident',
            'type' => 'add_disaster_report_date',
        ]);

        CRUD::addField([
            'name' => 'incident_time',
            'label' => 'Time of Incident',
            'type' => 'add_disaster_report_time',
        ]);

        CRUD::addField([
            'name' => 'barangay_id',
            'label' => 'Barangay',
            'type' => 'add_disaster_report_select',
            'entity' => 'barangay',
            'model' => 'App\Models\Barangay',
            'attribute' => 'name',
            'pivot' => false,
            'options' => function ($query) {
                return $query->where('barangay_rep_id', auth()->user()->id)->get();
            }, // Automatically selects the logged-in barangay
            'attributes' => [
                'readonly' => 'readonly', // Makes the field non-editable
            ],
        ]);

        CRUD::addField([
            'name' => 'exact_location',
            'label' => 'Exact Location',
            'type' => 'add_disaster_report_text',
        ]);

        CRUD::addField([
            'name' => 'disaster_type',
            'label' => 'Disaster Type',
            'type' => 'add_disaster_report_checklist',
            // 'model' => 'App\Models\DisasterType',
            // 'attribute' => 'name',
            'options' => [
                'flood' => 'Flood',
                'fire' => 'Fire',
                'earthquake' => 'Earthquake',
            ],
        ]);

        CRUD::addField([
            'name' => 'caused_by',
            'label' => 'Caused By',
            'type' => 'add_disaster_report_text',
        ]);

        CRUD::addField([
            'name' => 'affected',
            'label' => 'Affected',
            'type' => 'add_disaster_report_affected',
        ]);

        CRUD::addField([
            'name' => 'immediate_needs',
            'label' => 'Immediate Needs',
            'type' => 'add_disaster_report_needs',
        ]);

        CRUD::addField([
            'name' => 'attachments',
            'label' => 'Attachments',
            'type' => 'add_disaster_report_upload_multiple',
            'disk' => 'uploads',
            'upload' => true, // Use this for handling file uploads
            'withFiles' => [
                'uploader' => \Backpack\CRUD\app\Library\Uploaders\MultipleFiles::class, // Need this for custom uploads
            ],
            'hint' => '<ul> <li>Can upload multiple attachments</li> </ul>'
        ]);

        CRUD::addField([
            'name' => 'table_end',
            'type' => 'custom_html',
            'value' => '</table>',
            'escaped' => false,
            'wrapper' => false,
        ]);

        CRUD::setValidation(DisasterReportRequest::class);
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

    public function store()
    {
        // dd($this->crud->getRequest()->all());

        $this->crud->hasAccessOrFail('create');

        // Custom logic: Add a generated disaster code
        $data = $this->crud->validateRequest();

        $data['disaster_type'] = json_encode($data['disaster_type']);

        $donationType = [];
        if ($data['immediate_needs_food']) {
            $donationType[] = 'Food';
        }
        if ($data['immediate_needs_nonfood']) {
            $donationType[] = 'NonFood';
        }
        if ($data['immediate_needs_medicine']) {
            $donationType[] = 'Medicine';
        }

        $data->preffered_donation_type = json_encode($donationType);

        // Handle file uploads
        if ($this->crud->getRequest()->hasFile('attachments')) {
            $files = $this->crud->getRequest()->file('attachments');
            $filePaths = [];

            foreach ($files as $file) {
                $filePaths[] = $file->store('attachments', 'public');
            }
            // dd(json_encode($filePaths));
            $data->attachments = json_encode($filePaths);
        }

        // $this->crud->registerFieldEvents();

        // insert item in the db
        // $item = $this->crud->create($this->crud->getStrippedSaveRequest($data));
        // $this->data['entry'] = $this->crud->entry = $item;
        DisasterRequest::create([
            "reported_by" => $data->reported_by ?? null,
            "incident_date" => $data->incident_date,
            "incident_time" => $data->incident_time,
            "barangay_id" => $data->barangay_id,
            "preffered_donation_type" => $data->preffered_donation_type,
            "exact_location" => $data->exact_location,
            "disaster_type" => $data->disaster_type,
            "caused_by" => $data->caused_by ?? null,
            "overview" => 'Disaster caused by '.  $data->caused_by . ' @ '. $data->incident_date.' '. $data->incident_time .'.',
            "affected_family" => $data->affected_family ?? null,
            "affected_person" => $data->affected_person ?? null,
            "immediate_needs_food" => $data->immediate_needs_food ?? null,
            "immediate_needs_medicine" => $data->immediate_needs_medicine  ?? null,
            "immediate_needs_nonfood" => $data->immediate_needs_nonfood  ?? null,
            "date_requested" => now('UTC'),
            "attachments" => $data->attachments ?? null,
        ]);

        // // Merge the custom data back into the request
        // $this->crud->getRequest()->merge($data);

        // Call Backpack's default store logic
        // return $this->traitStore();


        \Alert::success('Disaster Request Sent to Admin for Approval')->flash();

        // $this->crud->setSaveAction();

        return redirect()->route('admin.dashboard');
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

        ]);

    }
}
