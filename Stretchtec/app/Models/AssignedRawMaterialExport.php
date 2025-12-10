<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 */
class AssignedRawMaterialExport extends Model
{
    protected $fillable = [
        'order_preperation_id',
        'export_raw_material_id',
        'assigned_quantity',
        'remarks',
    ];


    public function exportRawMaterial(): BelongsTo
    {
        return $this->belongsTo(ExportRawMaterial::class, 'export_raw_material_id');
    }

    public function orderPreparation(): BelongsTo
    {
        return $this->belongsTo(ProductOrderPreperation::class, 'order_preperation_id');
    }
}
