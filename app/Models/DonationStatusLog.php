<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationStatusLog extends Model
{
    use HasFactory;

    protected $table = "donation_status_logs";
    protected $fillable = [
        'donor_id',
        'barangay_id',
        'donation_id',
        'status',
        'status_change_proof',
        'status_change_remarks',
    ];

    public function donor(){
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function donation(){
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
