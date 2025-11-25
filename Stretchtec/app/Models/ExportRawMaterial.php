<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ExportRawMaterial extends Model
{
    protected $fillable = [
        'supplier',
        'product_description',
        'net_weight',
        'unit_price',
        'total_amount',
        'notes',
    ];
}
