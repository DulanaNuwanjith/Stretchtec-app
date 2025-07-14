<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SamplePreparationRnD extends Model
{
    protected $table = 'sample_preparation_rnd'; 

    protected $fillable = [
        'sample_inquiry_id',
        'orderNo',
        'customerRequestDate',
        'developPlannedDate',
        'is_dev_plan_locked',
        'colourMatchSentDate',
        'colourMatchReceiveDate',
        'yarnOrderedDate',
        'yarnOrderedPONumber',
        'is_po_locked',
        'shade',
        'is_shade_locked',
        'yarnOrderedQty',
        'is_qty_locked',
        'tkt',
        'is_tkt_locked',
        'yarnSupplier',
        'is_supplier_locked',
        'yarnReceiveDate',
        'productionDeadline',
        'is_deadline_locked',
        'sendOrderToProductionStatus',
        'productionStatus',
        'referenceNo',
        'is_reference_locked',
        'productionOutput',
        'note',
    ];

    protected $casts = [
        'customerRequestDate' => 'date',
        'developPlannedDate' => 'date',
        'colourMatchSentDate' => 'datetime',
        'colourMatchReceiveDate' => 'datetime',
        'yarnOrderedDate' => 'datetime',
        'yarnReceiveDate' => 'datetime',
        'productionDeadline' => 'date',
        'sendOrderToProductionStatus' => 'datetime',
        'is_dev_plan_locked' => 'boolean',
        'is_po_locked' => 'boolean',
        'is_shade_locked' => 'boolean',
        'is_qty_locked' => 'boolean',
        'is_tkt_locked' => 'boolean',
        'is_supplier_locked' => 'boolean',
        'is_deadline_locked' => 'boolean',
        'is_reference_locked' => 'boolean',
    ];

    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class, 'sample_inquiry_id');
    }
}
