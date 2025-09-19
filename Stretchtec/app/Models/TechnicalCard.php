<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalCard extends Model
{
    protected $fillable = [
        'reference_note',
        'size',
        'color',
        'rubber_type',
        'weft_yarn',
        'warp_yarn',
        'knitting_machine',
        'wheel_up',
        'wheel_down',
        'needles',
        'stretch',
        'weight',
        'special_remarks',
    ];

    // Add relationships and other model methods as needed
}
