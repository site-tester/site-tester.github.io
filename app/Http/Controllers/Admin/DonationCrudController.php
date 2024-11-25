<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonationRequest;
use App\Models\Barangay;
use App\Models\Donation;
use App\Models\User;
use App\Notifications\DonationApprovalNotification;
use App\Notifications\DonorDonationStatusNotification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class DonationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DonationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Donation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/donation');
        CRUD::setEntityNameStrings('donation', 'donations');
        $this->crud->addButtonFromView('top', 'print_button', 'print_button');
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
        CRUD::setListView('vendor.backpack.crud.donation_list');
        $show = request()->get('show');
        CRUD::removeButton('reset');

        if ($show == 'Active') {
            // Apply a filter to the query based on the status
            CRUD::setEntityNameStrings('Active Donation', 'Active Donations');
            CRUD::addClause('where', 'status', '!=', 'Pending Approval');
            $this->data['breadcrumbs'] = [
                trans('backpack::base.dashboard') => backpack_url('dashboard'),
                'Active Donations' => false,
                'Lists' => false,
            ];
            $this->crud->removeAllButtons();
        }

        if ($show == 'Pending') {
            // Apply a filter to the query based on the status
            CRUD::setEntityNameStrings('Donation Aprroval', 'Donation Aprrovals');
            CRUD::addClause('where', 'status', '=', 'Pending Approval');
            $this->data['breadcrumbs'] = [
                trans('backpack::base.dashboard') => backpack_url('dashboard'),
                'Donation Approval' => false,
                'Lists' => false,
            ];
            $this->crud->removeAllButtons();
        }


        // $this->data['overviewData'] = [
        //     'pendingDonation' => Donation::where('status', 'Pending Approval')->count(),
        //     'thisDayDonation' => Donation::whereDate('created_at', now()->toDateString())->count(),
        //     'approvedDonation' => Donation::whereDate('updated_at', now()->toDateString())->where('status', 'Approved')->count(),
        // ];

        // // Apply custom filters based on query parameters
        // if (request()->has('status')) {
        //     $status = request('status');
        //     if ($status === 'pending') {
        //         CRUD::addClause('where', 'status', 'Pending Approval');
        //     } elseif ($status === 'approved') {
        //         CRUD::addClause('where', 'status', 'Approved');
        //         CRUD::addClause('whereDate', 'updated_at', now()->toDateString());
        //     }
        // }

        // if (request()->has('date')) {
        //     $date = request('date');
        //     if ($date === 'today') {
        //         CRUD::addClause('whereDate', 'created_at', now()->toDateString());
        //     }
        // }

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
        if (auth()->user()->hasRole('Barangay Representative')) {
            // Get the barangay_id of the authenticated user
            $barangayRepId = auth()->user()->id;
            $barangayId = Barangay::where('barangay_rep_id', $barangayRepId)->first();
            // dd($barangayId);
            // Add a filter clause to only show donations related to the user's barangay
            CRUD::addClause('where', 'barangay_id', $barangayId->id);

        }
        if ($show == 'Pending') {
            CRUD::addColumn([
                'name' => 'id',
                'label' => 'Donation ID',
            ]);

            CRUD::addColumn([
                'name' => 'donor_id',
                'label' => 'Donor Name',
                'entity' => 'donor',
                'model' => 'App\Models\User',
                'attribute' => 'name',
                'pivot' => false,
                'type' => 'closure',
                'function' => function ($entry) {
                    $donor = Donation::where('id', $entry->id)->firstOrFail();
                    return $donor->anonymous == 0 ? $donor->donor->name : 'Anonymous';
                },
            ]);

            CRUD::addColumn([
                'name' => 'barangay_id',
                'label' => 'Barangay Recipient',
                'entity' => 'barangay',
                'model' => 'App\Models\Barangay',
                'attribute' => 'name',
                'pivot' => false,
            ]);

            CRUD::addColumn([
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
                            return 'badge text-bg-danger'; // Yellow indicates a warning
                        }
                        if ($column['text'] == 'Received') {
                            return 'badge text-bg-primary'; // Grey indicates a neutral state (received but not processed yet)
                        }
                        if ($column['text'] == 'Distributed') {
                            return 'badge text-bg-primary'; // Green indicates the process is complete
                        }
                        return 'badge badge-default';
                    },
                ],
            ]);

            CRUD::addColumn([
                'name' => 'status_approval',
                'label' => 'Verification',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    // Ensure the $entry is not null and the status is set
                    if (!$entry) {
                        return ''; // Return an empty string or default HTML
                    }

                    // Define the button styles based on the current status
                    $checkButton = '<button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#approveModal" data-id="' . $entry->id . '" ';
                    $xButton = '<button class="btn btn-danger btn-lg" onclick="updateDonationStatus(' . $entry->id . ', \'Rejected\')" ';
                    $viewButton = '<a class="btn btn-info btn-lg" href="' . route("donation.show", $entry->id) . '">';


                    // Check the current status of the entry and adjust the buttons accordingly
                    if ($entry->status == 'Pending Approval') {
                        // Both action buttons are clickable if the status is Pending Approval
                        $checkButton .= '>';
                        $xButton .= '>';
                        // $viewButton .= '>';
                    } elseif ($entry->status == 'Approved') {
                        // If the status is Approved, disable the X button
                        $checkButton .= 'style="pointer-events: none;">';
                        $xButton .= 'disabled style="background-color: #ccc; border-color: #ccc;">'; // Grey out X button
                        // $viewButton .= '>';
                    } elseif ($entry->status == 'Rejected') {
                        // If the status is Rejected, disable the check button
                        $checkButton .= 'disabled style="background-color: #ccc; border-color: #ccc;">'; // Grey out check button
                        $xButton .= 'style="pointer-events: none;">';
                        // $viewButton .= '>';
                    }

                    // Add the icon HTML to all buttons
                    $checkButton .= '<i class="la la-check-circle"></i></button>';
                    $xButton .= '<i class="la la-times-circle"></i></button>';
                    $viewButton .= '<i class="la la-eye"></i></a>';


                    // Return all buttons
                    return $viewButton . ' ' . $checkButton . ' ' . $xButton;
                },
                'escaped' => false,
            ]);
        }

        if ($show == 'Active') {
            CRUD::addColumn([
                'name' => 'donation_date',
                'label' => 'Donation Date'
            ]);

            CRUD::addColumn([
                'name' => 'donor_id',
                'label' => 'Donor Name',
                'entity' => 'donor',
                'model' => 'App\Models\User',
                'attribute' => 'name',
                'pivot' => false,
                'type' => 'closure',
                'function' => function ($entry) {
                    $donor = Donation::where('id', $entry->id)->firstOrFail();
                    return $donor->anonymous == 0 ? $donor->donor->name : 'Anonymous';
                },

            ]);
            CRUD::addColumn([
                'name' => 'type',
                'label' => 'Category',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $rawValue = $entry->type;
                    $rawValue = stripslashes($rawValue);
                    $cleanValue = trim($rawValue, '"');
                    $decoded = json_decode($cleanValue, true);
                    $formatted = array_map('ucfirst', $decoded);
                    return implode(', ', $formatted);

                },
            ]);

            CRUD::addColumn([
                'name' => 'approved_by',
                'label' => 'Approved By',
            ]);

            CRUD::addColumn([
                'name' => 'received_by',
                'label' => 'Received By',
                'type' => 'closure',
                'function' => function ($entry) {
                    return $$entry->received_by ?? 'Pending';
                },
            ]);

            CRUD::addColumn([
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
                            return 'badge text-bg-danger'; // Yellow indicates a warning
                        }
                        if ($column['text'] == 'Received') {
                            return 'badge text-bg-primary'; // Grey indicates a neutral state (received but not processed yet)
                        }
                        if ($column['text'] == 'Distributed') {
                            return 'badge text-bg-primary'; // Green indicates the process is complete
                        }
                        return 'badge badge-default';
                    },
                ],
            ]);

            CRUD::addColumn([
                'name' => 'status_approval',
                'label' => 'Details',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    // Ensure the $entry is not null and the status is set
                    if (!$entry) {
                        return ''; // Return an empty string or default HTML
                    }

                    // Define the button styles based on the current status
                    $viewButton = '<a class="btn btn-info btn-lg" href="' . route("donation.show", $entry->id) . '">';
                    // Check the current status of the entry and adjust the buttons accordingly
                    $viewButton .= '<i class="la la-eye"></i></a>';

                    // Return all buttons
                    return $viewButton;
                },
                'escaped' => false,
            ]);
        }

        return view(CRUD::getListView(), $this->data);
    }

    protected function approveDonation(Request $request, $id)
    {
        try {
            $donation = Donation::findOrFail($id);
            $donation->approved_by = $request->input('approver_name'); // Save the approver's name
            $donation->status = 'Approved'; // Update status to approved

            if ($donation->status === "Approved") {
                // Send notification to the donor
                $donation->donor->notify(new DonationApprovalNotification($donation));
            };

            $donation->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DonationRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */


        // Field for Donor
        CRUD::addField([
            'name' => 'donor_id',
            'label' => 'Donor Name',
            'class' => 'rounded',
            'type' => 'select', // Use select2 for better UX
            'entity' => 'donor', // The relationship defined in your Donation model
            'model' => 'App\Models\User', // Model for donor
            'attribute' => 'name', // Column to be shown in the select options
            'pivot' => false, // Not a pivot relationship
            // 'query' => User::where($this->crud->getCurrentEntry()->donor_id)->pluck('name', 'id'),
        ]);

        // Field for Barangay
        CRUD::addField([
            'name' => 'barangay_id',
            'label' => 'Barangay',
            'type' => 'select',
            'entity' => 'barangay', // The relationship defined in your Donation model
            'model' => 'App\Models\Barangay', // Model for barangay
            'attribute' => 'name', // Column to be shown in the select options
            'pivot' => false, // Not a pivot relationship
        ]);

        CRUD::addField([
            'name' => 'items',
            'label' => 'Items',
            'type' => 'hidden',
        ]);

        CRUD::addField([
            'name' => 'items',
            'label' => 'Donation Items',
            'type' => 'custom_html',
            'value' => $this->formatItems($this->crud->getCurrentEntry()->items, 'border'), // Pass an empty array initially or provide default data
        ]);

        CRUD::addField([
            'name' => 'images',
            'label' => 'Images',
            'type' => 'custom_html',
            'value' => $this->formatImages($this->crud->getCurrentEntry()->images, 'border', '<label>Donation Images</label>'), // Pass an empty array initially or provide default data
        ]);

        // Field for Status
        CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'Pending Approval' => 'Pending Approval',
                'Approved' => 'Approved',
                'Rejected' => 'Rejected',
                'Received' => 'Received',
                'Distributed' => 'Distributed',
            ],
            'allows_multiple' => false, // Set to true if you want to allow multiple selections
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
        CRUD::setValidation(DonationRequest::class);

        // Field for Donor
        CRUD::addField([
            'name' => 'donor_id',
            'label' => 'Donor Name',
            'class' => 'rounded',
            'type' => 'select', //
            'entity' => 'donor', // The relationship defined in your Donation model
            'model' => 'App\Models\User', // Model for donor
            'attribute' => 'name', // Column to be shown in the select options
            'pivot' => false, // Not a pivot relationship
            'options' => (function ($query) {
                return $query->whereHas('roles', function ($q) {
                    $q->where('name', 'Normal User'); // Filter by role "Normal User"
                })->get();
            }),
        ]);

        // Field for Barangay
        CRUD::addField([
            'name' => 'barangay_id',
            'label' => 'Barangay',
            'type' => 'select',
            'entity' => 'barangay', // The relationship defined in your Donation model
            'model' => 'App\Models\Barangay', // Model for barangay
            'attribute' => 'name', // Column to be shown in the select options
            'pivot' => false, // Not a pivot relationship
        ]);

        CRUD::addField([
            'name' => 'donationUpdateItems',
            'label' => 'Donation Items',
            'type' => 'custom_html',
            'value' => '
                <label for="donationUpdateItems" class="form-label">Donation Items</label>
                <div>' . view('vendor.backpack.crud.columns.update_custom_table', ['donationItems' => CRUD::getCurrentEntry()->donationItems])->render() . '</div>',
        ]);

        CRUD::addField([
            'name' => 'donation_date',
            'label' => 'Appointment Date',
            'type' => 'date',
            // 'attributes' => [
            //     'min' => Carbon::now()->format('Y-m-d'),
            // ]
        ]);

        $this->crud->addField([
            'name' => 'donation_time',
            'label' => "Appointment Time",
            'type' => 'select_from_array',
            'options' => [
                '09:00 AM - 10:00 AM' => '9:00 AM - 10:00 AM',
                '10:00 AM - 11:00 AM' => '10:00 AM - 11:00 AM',
                '11:00 AM - 12:00 PM' => '11:00 AM - 12:00 PM',
                '01:00 PM - 02:00 PM' => '01:00 PM - 02:00 PM',
                '02:00 PM - 03:00 PM' => '02:00 PM - 03:00 PM',
                '03:00 PM - 04:00 PM' => '03:00 PM - 04:00 PM',
            ],
            'allows_null' => false,
            'value' => $this->crud->getCurrentEntry()->donation_time, // Default or saved value
        ]);

        // Field for Status
        CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'Pending Approval' => 'Pending Approval',
                'Approved' => 'Approved',
                'Rejected' => 'Rejected',
                'Received' => 'Received',
                'Distributed' => 'Distributed',
            ],
            'allows_multiple' => false, // Set to true if you want to allow multiple selections
        ]);

        // Coordinator Field Wrapper (hidden initially)
        CRUD::addField([
            'name' => 'coordinator',
            'label' => 'Coordinator',
            'type' => 'text',
            'wrapper' => [
                'class' => 'd-none', // Hide by default using Bootstrap class 'd-none'
                'id' => 'coordinator-wrapper',  // Add an ID to target it in JavaScript
            ],
            'default' => isset($this->crud->getCurrentEntry()->coordinator)
                ? $this->crud->getCurrentEntry()->coordinator
                : '', // Set default value if coordinator exists
        ]);

        // JavaScript to control the visibility of the Coordinator field
        CRUD::addField([
            'name' => 'script',
            'type' => 'custom_html',
            'value' => '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const statusField = document.querySelector("select[name=\'status\']");
                const coordinatorWrapper = document.getElementById("coordinator-wrapper");

                // Function to toggle Coordinator visibility
                function toggleCoordinatorField() {
                    if (statusField.value === "Distributed") {
                        coordinatorWrapper.classList.remove("d-none");
                    } else {
                        coordinatorWrapper.classList.add("d-none");
                        coordinatorWrapper.querySelector("input").value = ""; // Clear the value if hidden
                    }
                }

                // Trigger toggle on page load and status change
                toggleCoordinatorField();
                statusField.addEventListener("change", toggleCoordinatorField);
            });
        </script>
        '
        ]);

        CRUD::addField([
            'name' => 'proof_document',
            'label' => 'Proof Document',
            'type' => 'upload',
            'disk' => 'uploads',
            'wrapper' => [
                'class' => 'form-group d-none', // Start hidden
            ],
            'upload' => true, // Use this for handling file uploads
            'withFiles' => true, // This is set to ensure file support
        ]);

        CRUD::addField([
            'name' => 'remarks',
            'label' => 'Remarks',
            'type' => 'textarea',
            'wrapper' => [
                'class' => 'form-group d-none', // Start hidden
            ],
        ]);

    }

    public function update(DonationRequest $request)
    {
        // Retrieve the donation entry before the update for comparison
        $donationBeforeUpdate = $this->crud->getCurrentEntry()->fresh();
        // Perform the update
        $response = $this->traitUpdate();
        // Retrieve the updated donation entry
        $donationAfterUpdate = $this->crud->getCurrentEntry();
        // Check if the 'status' field was modified
        if ($donationBeforeUpdate->status !== $donationAfterUpdate->status) {
            // Retrieve the donor if the relationship exists
            $donor = $donationAfterUpdate->donor;

            if ($donationAfterUpdate->status == 'Approve') {
                if ($donor) {
                    $donor->notify(new DonationApprovalNotification($donationAfterUpdate));
                }
            } else {
                if ($donor) {
                    $donor->notify(new DonorDonationStatusNotification($donationAfterUpdate));
                }
            }
            // Send notification to the donor if they exist
            // if ($donor) {
            //     $donor->notify(new DonorDonationStatusNotification($donationAfterUpdate));
            // }
        }
        return $response;
    }

    public function setupShowOperation()
    {
        CRUD::setEntityNameStrings('Donation Preview', 'Donation Preview');
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
                            return 'badge text-bg-danger'; // Yellow indicates a warning
                        }
                        if ($column['text'] == 'Received') {
                            return 'badge text-bg-secondary'; // Grey indicates a neutral state (received but not processed yet)
                        }
                        if ($column['text'] == 'Distributed') {
                            return 'badge text-bg-success'; // Green indicates the process is complete
                        }

                        return 'badge badge-default';
                    },
                ],
            ],
            [
                'name' => 'donor_id',
                'label' => 'Donor Name',
                'entity' => 'donor',
                'model' => 'App\Models\User',
                'attribute' => 'name',
                'pivot' => false,
                'type' => 'closure',
                'function' => function ($entry) {
                    $donor = Donation::where('id', $entry->id)->firstOrFail();
                    return $donor->anonymous == 0 ? $donor->donor->name : 'Anonymous';
                },
            ],
            [
                'name' => 'barangay_id',
                'label' => 'Barangay',
                'entity' => 'barangay',
                'model' => 'App\Models\Barangay',
                'attribute' => 'name',
                'pivot' => false,
            ],
            [
                'name' => 'approved_by',
                'label' => 'Approved By',
                'type' => 'closure',
                'function' => function ($entry) {
                    return $entry->approved_by ?? 'Pending';
                },
            ],
            [
                'name' => 'received_by',
                'label' => 'Received By',
                'type' => 'closure',
                'function' => function ($entry) {
                    return $entry->received_by ?? 'Pending';
                },
            ],
            [
                'name' => 'distributed_by',
                'label' => 'Distributed By',
                'type' => 'closure',
                'function' => function ($entry) {
                    return $entry->distributed_by ?? 'Pending';
                },
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    $rawValue = $entry->type;
                    $rawValue = stripslashes($rawValue);
                    $cleanValue = trim($rawValue, '"');
                    $decoded = json_decode($cleanValue, true);
                    $formatted = array_map('ucfirst', $decoded);
                    return implode(', ', $formatted);

                },
            ],
            [
                'name' => 'donationItems',
                'label' => 'Item/s',
                'type' => 'custom_html',
                'value' => function ($entry) {
                    return view('vendor.backpack.crud.columns.custom_table', ['entry' => $entry])->render();
                }

            ],
            [
                'name' => 'donation_date',
                'label' => 'Appointment Date',
                'type' => 'text',
                'value' => function ($entry) {
                    return \Carbon\Carbon::parse($entry->donation_date)->format('Y-m-d');
                },
            ],
            [
                'name' => 'donation_time',
                'label' => 'Appointment Time',
                'type' => 'text',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'date',
            ],
            [
                'name' => 'updated_at',
                'label' => 'Updated At',
                'type' => 'date',
            ],
            // Add other fields you want to display
        ]);
    }

    protected function formatImages($jsonData, $class, $label)
    {
        // Decode the JSON data if it's a string
        if (is_string($jsonData)) {
            $images = json_decode($jsonData, true); // Decode the JSON into an array
        } else {
            $images = $jsonData; // If it's already an array, use it directly
        }

        // Handle empty images case
        if (empty($images)) {
            return '<p>No images available.</p>';
        }

        $output = '<div>' . $label . ' <div class="p-2 ' . $class . '" >'; // Start a container div
        foreach ($images as $image) {
            // Generate an img tag for each image path
            $output .= '<img src="' . asset('storage/' . $image) . '" alt="Donation Image" style="max-width: 150px; margin-right: 10px;">';
        }
        $output .= '</div></div>'; // End the container div

        return $output; // Return the formatted HTML
    }
    protected function formatItems($jsonData, $class)
    {
        $items = json_decode($jsonData, true); // Decode JSON into an array
        if (empty($items)) {
            return '<p>No items available.</p>'; // Handle the case with no items
        }

        $output = '<label>Donation Items (Read-Only)</label>
        <ul class="' . $class . ' px-5 py-2">'; // Start an unordered list
        foreach ($items as $item) {
            $output .= '<li>' . htmlspecialchars($item['name']) . ' - Quantity: ' . htmlspecialchars($item['quantity']) . '</li>'; // Format each item
        }
        $output .= '</ul>'; // End the unordered list
        return $output; // Return the formatted HTML
    }

    public function updateStatus(Request $request, $id)
    {
        // Find the donation entry
        $entry = Donation::find($id);
        // Log the entry's details
        Log::info('Donation entry:', $entry->toArray());

        if ($entry) {
            // Get the donor associated with the donation
            $user = User::find($entry->donor_id);

            if (!$user) {
                // Handle case where no donor is found
                return response()->json([
                    'success' => false,
                    'message' => 'Donor not found for this donation.'
                ]);
            };

            // Update the donation status based on the request
            $entry->status = $request->status;

            // If the status is 'Approved', send the notification
            if ($entry->status === "Approved") {
                // Send notification to the donor
                $user->notify(new DonationApprovalNotification($entry));
            };

            // Save the updated donation status
            $entry->save();

            return response()->json([
                'success' => true,
                'message' => 'Donation ID:' . $id . ' ' . $entry->status,
                'status' => $entry->status
            ]);
        }

        // Return an error response if the donation entry was not found
        return response()->json([
            'success' => false,
            'message' => 'Donation request not found.'
        ]);
    }


}
