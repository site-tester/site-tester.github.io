<?php

namespace App\Models;

use App\Notifications\DonationRequestNotification;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RequestDonation extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'request_donations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'barangay_id'
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


    protected static function booted()
    {
        static::updating(function ($donation) {
            // Check if the status is being changed to 'Approved'
            // if ($donation->isDirty('status') && $donation->status === 'Approved') {
            //     $donors = User::role('Normal User')->get();
            //     $barangay = Barangay::where('id', $donation->barangay)->first();

            //     foreach ($donors as $donor) {
            //         $donor->notify(new DonationRequestNotification($donation, $barangay));
            //     }
            // }
        });
    }
}
