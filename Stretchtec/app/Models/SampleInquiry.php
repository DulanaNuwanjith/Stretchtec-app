<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleInquiry extends Model
{
    protected $fillable = [
        'orderFile',
        'orderNo',
        'inquiryReceiveDate',
        'customerName',
        'merchandiseName',
        'coordinatorName',
        'item',
        'ItemDiscription',
        'size',
        'qtRef',
        'color',
        'style',
        'sampleQty',
        'customerSpecialComment',
        'customerRequestDate',
        'alreadyDeveloped',
        'sentToSampleDevelopmentDate',
        'developPlannedDate',
        'productionStatus',
        'referenceNo',
        'customerDeliveryDate',
        'dNoteNumber',
        'customerDecision',
        'notes',
        'deliveryQty',
        'rejectNO',
    ];

    protected $casts = [
        'inquiryReceiveDate' => 'date',
        'customerRequestDate' => 'date',
        'developPlannedDate' => 'date',
        'customerDeliveryDate' => 'datetime'
    ];

    public function samplePreparationRnD()
    {
        return $this->hasOne(SamplePreparationRnD::class);
    }

    public function productCatalog()
    {
        return $this->hasOne(ProductCatalog::class);
    }

    public function samplePreparationProduction()
    {
        return $this->hasOneThrough(
            SamplePreparationProduction::class,
            SamplePreparationRnD::class,
            'sample_inquiry_id',        // Foreign key on sample_preparation_rnd table
            'sample_preparation_rnd_id',// Foreign key on sample_preparation_production table
            'id',                       // Local key on inquiry table
            'id'                        // Local key on sample_preparation_rnd table
        );
    }


    protected static function booted()
    {
        static::updated(function ($inquiry) {
            if (
                $inquiry->isDirty('referenceNo') &&
                !empty($inquiry->referenceNo) &&
                !$inquiry->productCatalog
            ) {
                $rnd = $inquiry->samplePreparationRnD;

                // Add check for alreadyDeveloped status before creating ProductCatalog
                if ($rnd && $rnd->alreadyDeveloped !== 'No Need to Develop') {
                    ProductCatalog::create([
                        'order_no' => $inquiry->orderNo,
                        'reference_no' => $inquiry->referenceNo,
                        'reference_added_date' => now(),
                        'coordinator_name' => $inquiry->coordinatorName,
                        'item' => $inquiry->item,
                        'size' => $inquiry->size,
                        'colour' => $inquiry->color,
                        'shade' => $rnd->shade,
                        'tkt' => $rnd->tkt,
                        'sample_inquiry_id' => $inquiry->id,
                        'sample_preparation_rnd_id' => $rnd->id,
                        'supplier' => $rnd->yarnSupplier,
                        'pst_no' => $rnd->pst_no,
                    ]);
                }
            }
        });
    }
}
