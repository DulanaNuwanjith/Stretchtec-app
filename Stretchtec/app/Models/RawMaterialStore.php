<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate(int $int)
 */
class RawMaterialStore extends Model
{
    protected $fillable = [
        'color',
        'shade',
        'tkt',
        'pst_no',
        'supplier',
        'available_quantity',
        'unit',
        'unit_price',
        'remarks',
    ];
}
