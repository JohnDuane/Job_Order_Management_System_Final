<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    protected $table = 'Vehicle';

    protected $primaryKey = 'vehicle_id';

    public $timestamps = false;

    protected $fillable = [
        'cust_id',
        'plate_number',
        'make',
        'engine_model',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }
}