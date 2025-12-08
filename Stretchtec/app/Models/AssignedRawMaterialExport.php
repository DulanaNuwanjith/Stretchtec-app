<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedRawMaterialExport extends Model
{
    protected $fillable = [
        'order_preperation_id',
        'export_raw_material_id',
        'assigned_quantity',
        'remarks',
    ];
}
