<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'item_name',
        'donation_type',
        'quantity',
        'expiration_date',
        'condition',
        'image_path',
    ];

    protected $casts = [
        'donation_type' => 'array',
    ];

    public function donation(){
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
