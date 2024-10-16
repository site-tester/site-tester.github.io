<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonationRequest;
use App\Models\Barangay;
use App\Models\User;
use App\Notifications\DonorDonationStatusNotification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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

        CRUD::addColumn([
            'name' => 'donor_id',
            'label' => 'Donor Name',
            'entity' => 'donor',
            'model' => 'App\Models\User',
            'attribute' => 'name',
            'pivot' => false,
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
                    if ($column['text'] == 'Awaiting Delivery') {
                        return 'badge text-bg-info'; // Blue indicates a process in motion
                    }
                    if ($column['text'] == 'Received') {
                        return 'badge text-bg-secondary'; // Grey indicates a neutral state (received but not processed yet)
                    }
                    if ($column['text'] == 'Under Segregation') {
                        return 'badge text-bg-primary'; // Primary indicates an active process
                    }
                    if ($column['text'] == 'Categorized') {
                        return 'badge text-bg-secondary'; // Grey indicates a state of readiness (categorized but not yet distributed)
                    }
                    if ($column['text'] == 'In Inventory') {
                        return 'badge text-bg-dark'; // Dark indicates stored and available for future use
                    }
                    if ($column['text'] == 'Ready for Distribution') {
                        return 'badge text-bg-primary'; // Primary to indicate it's actively ready for distribution
                    }
                    if ($column['text'] == 'Distributed') {
                        return 'badge text-bg-success'; // Green indicates the process is complete
                    }
                    if ($column['text'] == 'Completed') {
                        return 'badge text-bg-dark'; // Dark indicates closure/completion
                    }

                    return 'badge badge-default';
                },
            ],
        ]);
        CRUD::removeButton('create');
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
                'Awaiting Delivery' => 'Awaiting Delivery',
                'Received' => 'Received',
                'Under Segregation' => 'Under Segregation',
                'Categorized' => 'Categorized',
                'In Inventory' => 'In Inventory',
                'Ready for Distribution' => 'Ready for Distribution',
                'Distributed' => 'Distributed',
                'Completed' => 'Completed',
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
                'Awaiting Delivery' => 'Awaiting Delivery',
                'Received' => 'Received',
                'Under Segregation' => 'Under Segregation',
                'Categorized' => 'Categorized',
                'In Inventory' => 'In Inventory',
                'Ready for Distribution' => 'Ready for Distribution',
                'Distributed' => 'Distributed',
                'Completed' => 'Completed',
            ],
            'allows_multiple' => false, // Set to true if you want to allow multiple selections
        ]);


    }

    public function update(DonationRequest $request)
    {
        $donationBeforeUpdate = $this->crud->getCurrentEntry()->fresh();
        // dd($donation->isDirty('status'));
        $response = $this->traitUpdate();
        $donationAfterUpdate = $this->crud->getCurrentEntry();
        // dd($donationBeforeUpdate->status, $donationAfterUpdate->status);
        // Check if the status was changed and notify the donor
        if ($donationBeforeUpdate->status !== $donationAfterUpdate->status) {
            $donor = $donationAfterUpdate->donor; // Assuming donor relationship is defined in Donation model
            $donor->notify(new DonorDonationStatusNotification($donationAfterUpdate)); // Send notification to the donor
        }
        return $response;
    }

    // public function update()
    // {

    //     $response = parent::update(); // Perform the update
    //     dd('Update method is called');
    //     $donation = $this->crud->getCurrentEntry(); // Get the updated entry

    //     // Check if the status has been updated to "In Inventory"
    //     if ($donation->status === 'In Inventory') {
    //         $this->addItemsToInventory($donation);
    //     }

    //     return  $response; // Return the original response
    // }

    // protected function addItemsToInventory($donation)
    // {
    //     $items = json_decode($donation->items, true); // Decode the items JSON

    //     // Loop through each item and add it to the inventory table
    //     foreach ($items as $item) {
    //         \DB::table('inventory')->insert([
    //             'item_name' => $item['name'],
    //             'quantity' => $item['quantity'],
    //             'donation_id' => $donation->id, // Link the donation ID to the inventory item
    //             'barangay_id' => $donation->barangay_id, // Reference the barangay
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }
    // }

    public function setupShowOperation()
    {
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
                        if ($column['text'] == 'Awaiting Delivery') {
                            return 'badge text-bg-info'; // Blue indicates a process in motion
                        }
                        if ($column['text'] == 'Received') {
                            return 'badge text-bg-secondary'; // Grey indicates a neutral state (received but not processed yet)
                        }
                        if ($column['text'] == 'Under Segregation') {
                            return 'badge text-bg-primary'; // Primary indicates an active process
                        }
                        if ($column['text'] == 'Categorized') {
                            return 'badge text-bg-secondary'; // Grey indicates a state of readiness (categorized but not yet distributed)
                        }
                        if ($column['text'] == 'In Inventory') {
                            return 'badge text-bg-dark'; // Dark indicates stored and available for future use
                        }
                        if ($column['text'] == 'Ready for Distribution') {
                            return 'badge text-bg-primary'; // Primary to indicate it's actively ready for distribution
                        }
                        if ($column['text'] == 'Distributed') {
                            return 'badge text-bg-success'; // Green indicates the process is complete
                        }
                        if ($column['text'] == 'Completed') {
                            return 'badge text-bg-dark'; // Dark indicates closure/completion
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
                'name' => 'type',
                'label' => 'Donation Type',
                'type' => 'text',
            ],
            [
                'name' => 'items',
                'label' => 'Item/s',
                'type' => 'custom_html',
                'value' => $this->formatItems($this->crud->getCurrentEntry()->items, ''), // Call a method to format the JSON data
                'escaped' => false,
            ],
            [
                'name' => 'images',
                'label' => 'Image/s',
                'type' => 'custom_html',
                'value' => $this->formatImages($this->crud->getCurrentEntry()->images, '', ''), // Call a method to format the JSON data
                // 'escaped' => false,
            ],
            [
                'name' => 'donation_date',
                'label' => 'Donation Date',
                'type' => 'date',
            ],
            [
                'name' => 'donation_time',
                'label' => 'Donation Time',
                'type' => 'time',
            ],
            [
                'name' => 'created_at',
                'label' => 'Created At',
                'type' => 'datetime',
            ],
            [
                'name' => 'updated_at',
                'label' => 'Updated At',
                'type' => 'datetime',
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

}
