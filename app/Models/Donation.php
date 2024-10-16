<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'donations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'donor_id',
        'barangay_id',
        'type',
        'items',
        'donation_date',
        'donation_time',
        'images',
        'status',
    ];
    // protected $hidden = [];
    protected $casts = [
        'items' => 'json', // Automatically casts JSON to array
        'images' => 'array', // Automatically casts JSON to array
        'donation_date' => 'date', // Casts to a Carbon date instance
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getStatusBadge()
    {
        $statusClasses = [
            'Pending' => 'badge badge-warning',  // Example class for pending
            'Approved' => 'badge badge-success',  // Example class for approved
            'Completed' => 'badge badge-primary',  // Example class for completed
            // Add more statuses as needed
        ];

        $statusClass = $statusClasses[$this->status] ?? 'badge badge-secondary'; // Default class
        return '<span class="' . $statusClass . '">' . ucfirst($this->status) . '</span>';
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id', 'id'); // Foreign key in donations table
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id'); // Foreign key in donations table
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getDonationTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A'); // Converts to 12-hour format with AM/PM
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setDonationTimeAttribute($value)
    {
        // Assuming $value is in 'HH:mm' format from the timepicker
        if ($value) {
            // Directly store the value in 'H:i:s' format
            $this->attributes['donation_time'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
        }
    }

    // Boot method to listen for model events
    protected static function booted()
    {
        static::saved(function ($donation) {
            if ($donation->status === 'In Inventory') {
                $donation->addItemsToInventory();
            }
        });
    }

    // Method to add items to the inventory
    public function addItemsToInventory()
    {
        $items = json_decode($this->items, true); // Decode the items JSON

        if (is_array($items)) {
            foreach ($items as $item) {
                \DB::table('inventory')->insert([
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'donation_id' => $this->id, // Link the donation ID to the inventory item
                    'barangay_id' => $this->barangay_id, // Reference the barangay
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
