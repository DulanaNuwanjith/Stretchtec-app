<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorMatchReject extends Model
{
    protected $table = 'color_match_rejects';

    protected $fillable = [
        'orderNo',
        'sentDate',
        'receiveDate',
        'rejectDate',
        'rejectReason',
    ];

    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class, 'orderNo', 'orderNo');
    }
}
