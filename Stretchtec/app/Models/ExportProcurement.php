<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 * @method static create(array $array)
 */
class ExportProcurement extends Model
{
    protected $fillable = [
        'date',
        'invoice_number',
        'supplier',
        'product_description',
        'net_weight',
        'unit_price',
        'uom',
        'total_amount',
        'total_weight',
        'invoice_value',
        'checked_by',
        'notes',
    ];
}
