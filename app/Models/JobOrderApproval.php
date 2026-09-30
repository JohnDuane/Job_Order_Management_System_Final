<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOrderApproval extends Model
{
    protected $table = 'Job_Order_Approval';
    public $timestamps = false;

    protected $fillable = [
        'job_order_id',
        'approved_by',
        'status',
        'remarks',
        'action_date',
    ];

    protected $casts = ['action_date' => 'date'];

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class, 'job_order_id', 'job_order_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
