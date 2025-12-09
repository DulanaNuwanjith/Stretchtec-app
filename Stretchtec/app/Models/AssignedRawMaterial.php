<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 */
class AssignedRawMaterial extends Model
{
    protected $fillable = [
        'order_preperation_id',
        'raw_material_store_id',
        'assigned_quantity',
        'remarks',
    ];
}
