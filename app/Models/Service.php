<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $table = 'Services';

    protected $primaryKey = 'service_id';

    public $timestamps = false;

    protected $fillable = [
        'service_name',
        'job_desc',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Services can belong to many job orders.
     */
    public function jobOrders(): BelongsToMany
    {
        return $this->belongsToMany(
            JobOrder::class,
            'Job_Order_Services',
            'service_id',
            'job_order_id',
            'service_id',
            'job_order_id'
        );
    }
}