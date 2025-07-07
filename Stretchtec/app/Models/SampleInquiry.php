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
        'size',
        'color',
        'sampleQty',
        'customerSpecialComment',
        'customerRequestDate',
        'alreadyDeveloped',
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
}
