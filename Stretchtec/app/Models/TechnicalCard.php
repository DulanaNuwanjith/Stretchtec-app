<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(mixed $validated)
 * @method static where(string $string, string $string1)
 * @property mixed $url
 */
class TechnicalCard extends Model
{
    protected $fillable = [
        'reference_number',
        'type',
        'size',
        'color',
        'yarn_count',
        'rubber_type',
        'spindles',
        'weft_yarn',
        'warp_yarn',
        'reed',
        'machine',
        'wheel_up',
        'wheel_down',
        'needles',
        'stretchability',
        'weight_per_yard',
        'url',
        'special_remarks',
    ];

    // Add relationships and other model methods as needed
}
