<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCatalog;

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
        'notes'
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
                        'order_no'                 => $inquiry->orderNo,
                        'reference_no'             => $inquiry->referenceNo,
                        'reference_added_date'     => now(),
                        'coordinator_name'         => $inquiry->coordinatorName,
                        'item'                     => $inquiry->item,
                        'size'                     => $inquiry->size,
                        'colour'                   => $inquiry->color,
                        'shade'                    => $rnd->shade,
                        'tkt'                      => $rnd->tkt,
                        'sample_inquiry_id'        => $inquiry->id,
                        'sample_preparation_rnd_id'=> $rnd->id,
                    ]);
                }
            }
        });
    }
}
