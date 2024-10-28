<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Barangay extends Model
{
    use CrudTrait;
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'barangays';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'barangay_rep_id',
        'flood_frequency',
        'flood_risk_score',
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getFloodRiskIcon()
    {
        if ($this->flood_risk_score > 7) {
            return '<i class="fas fa-flood" style="color: red;"></i>'; // High risk
        } elseif ($this->flood_risk_score > 3) {
            return '<i class="fas fa-tint" style="color: orange;"></i>'; // Medium risk
        } else {
            return '<i class="fas fa-water" style="color: green;"></i>'; // Low risk
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function barangayRep()
    {
        return $this->belongsTo(User::class, 'barangay_rep_id', 'id'); // Adjust the foreign key if necessary
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
}
