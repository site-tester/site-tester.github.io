<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flood extends Model
{
    use HasFactory;

    protected $table = "floods";

    protected $fillable = [
        'barangay_id',
        'flood_level',
        'severity_score',
    ];
}
