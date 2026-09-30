<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOrderAssignment extends Model
{
    protected $table = 'Job_Order_Assignment';
    public $timestamps = false;

    protected $fillable = [
        'job_order_id',
        'staff_id',
        'assigned_by',
        'assigned_date',
        'remarks',
    ];

    protected $casts = ['assigned_date' => 'date'];

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id', 'job_order_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
