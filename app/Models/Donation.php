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
        'coordinator',
        'type',
        'donation_date',
        'donation_time',
        'proof_document',
        'remarks',
        'status',
    ];
    // protected $hidden = [];
    protected $casts = [
        'images' => 'array', // Automatically casts JSON to array
        'donation_date' => 'date', // Casts to a Carbon date instance
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // public function getStatusBadge()
    // {
    //     $statusClasses = [
    //         'Pending' => 'badge badge-warning',  // Example class for pending
    //         'Approved' => 'badge badge-success',  // Example class for approved
    //         'Completed' => 'badge badge-primary',  // Example class for completed
    //         // Add more statuses as needed
    //     ];

    //     $statusClass = $statusClasses[$this->status] ?? 'badge badge-secondary'; // Default class
    //     return '<span class="' . $statusClass . '">' . ucfirst($this->status) . '</span>';
    // }
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
    public function donationItems()
    {
        return $this->hasMany(DonationItem::class);
    }
    public function donationUpdateItems()
    {
        return $this->hasMany(DonationItem::class, 'donation_id');
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
    // public function getDonationTimeAttribute($value)
    // {
    //     return Carbon::parse($value)->format('h:i A'); // Converts to 12-hour format with AM/PM
    // }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    // public function setDonationTimeAttribute($value)
    // {
    //     // Assuming $value is in 'HH:mm' format from the timepicker
    //     if ($value) {
    //         // Directly store the value in 'H:i:s' format
    //         $this->attributes['donation_time'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    //     }
    // }

    // Boot method to listen for model events
    protected static function booted()
    {
        static::saved(function ($donation) {
            if ($donation->status !== 'Pending Approval') {
                // Need Code Here to save about status update proof in Donation Status Log (Model: DonationStatusLog)
                $donation->changeDonationStatusLog($donation);
            }

            if ($donation->status === 'Received') {
                $donation->addItemsToInventory($donation->id);
            }
            
            if ($donation->status === 'Distributed') {
                $donation->removeItemsFromInventory($donation->id);
            }
        });
    }

    public function addItemsToInventory($id)
    {
        $items = DonationItem::where('donation_id', $id)->get();

        foreach ($items as $item) {
            \DB::table('inventory')->insert([
                'donation_id' => $item->donation_id, // Link the donation ID to the inventory item
                'barangay_id' => $item->donation->barangay->id, // Reference the barangay
                'name' => $item->item_name,
                'donation_type' => $item->donation->type,
                'quantity' => $item->quantity,
                'expiration_date' => $item->expiration_date ? $item->expiration_date : null,
                'condition' => $item->condition ? $item->condition : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
    
    public function removeItemsFromInventory($id)
    {
        \DB::table('inventory')->where('donation_id', $id)->delete();
    }

    public function changeDonationStatusLog($donation)
    {
            DonationStatusLog::create([
                'donor_id' => $donation->donor_id,
                'barangay_id' => $donation->barangay_id,
                'donation_id' => $donation->id,
                'status' => $donation->status,
                'status_change_proof' => $donation->proof_document,
                'status_change_remarks' => $donation->remarks,
            ]);
    }
}
