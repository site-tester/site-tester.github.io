<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calamity extends Model
{
    use HasFactory;

    protected $table = 'calamities';

    protected $fillable = [
        'barangay_id',
        'calamity_type',
        'severity_level',
        'affected_population',
        'available_resources',
        'response_capacity',
        'calamity_date',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

}
