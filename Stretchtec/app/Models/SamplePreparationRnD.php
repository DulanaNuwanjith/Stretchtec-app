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
        'tkt',
        'is_tkt_locked',
        'yarnSupplier',
        'yarnPrice',
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
        'alreadyDeveloped',
        'yarnOrderedWeight',
        'is_yarn_ordered_weight_locked',
        'yarnLeftoverWeight',
        'is_yarn_leftover_weight_locked',
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
        'is_tkt_locked' => 'boolean',
        'is_supplier_locked' => 'boolean',
        'is_deadline_locked' => 'boolean',
        'is_reference_locked' => 'boolean',
        'alreadyDeveloped' => 'string',
        'is_yarn_ordered_weight_locked' => 'boolean',
        'is_yarn_leftover_weight_locked' => 'boolean',
    ];

    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class, 'sample_inquiry_id');
    }

    protected static function booted()
    {
        static::saved(function ($prep) {
            if ($prep->sampleInquiry && ($prep->isDirty('referenceNo') || $prep->isDirty('developPlannedDate'))) {
                $updateData = [];

                if ($prep->isDirty('referenceNo')) {
                    $updateData['referenceNo'] = $prep->referenceNo;
                }

                if ($prep->isDirty('developPlannedDate')) {
                    $updateData['developPlannedDate'] = $prep->developPlannedDate;
                }

                if (!empty($updateData)) {
                    $prep->sampleInquiry->update($updateData);
                }
            }
        });
    }

    public function production()
    {
        return $this->hasOne(SamplePreparationProduction::class, 'sample_preparation_rnd_id');
    }
}
