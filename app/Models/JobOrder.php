<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOrder extends Model
{
    protected $table = 'Job_Order';
    protected $primaryKey = 'job_order_id';
    public $timestamps = false;

    protected $fillable = [
        'cust_id',
        'vehicle_id',
        'created_by',
        'problem_description',
        'remarks',
        'status',
        'date_issued',
        'expected_empl_date',
        'total_cost',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'expected_empl_date' => 'date',
        'total_cost' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'Job_Order_Services',
            'job_order_id',
            'service_id',
            'job_order_id',
            'service_id'
        );
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(JobOrderAssignment::class, 'job_order_id', 'job_order_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(JobOrderApproval::class, 'job_order_id', 'job_order_id');
    }

    public function getCodeAttribute(): string
    {
        return 'JO-' . str_pad((string) $this->job_order_id, 4, '0', STR_PAD_LEFT);
    }

    public function latestApproval(): ?JobOrderApproval
    {
        return $this->approvals()->latest('id')->first();
    }
}
