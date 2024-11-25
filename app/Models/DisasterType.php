<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class DisasterType extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $casts = [
        'disaster_type' => 'array',
        'attachments' => 'array',
    ];

}
