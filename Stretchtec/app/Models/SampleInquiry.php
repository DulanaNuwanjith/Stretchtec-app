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
        'item',
        'itemDiscription',
        'size',
        'color',
        'sampleQty',
        'customerSpecialComment',
        'customerRequestDate',
        'alreadyDeveloped',
        'sentToSampleDevelopmentDate',
        'developPlannedDate',
        'productionStatus',
        'referenceNo',
        'customerDeliveryDate',
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

}
