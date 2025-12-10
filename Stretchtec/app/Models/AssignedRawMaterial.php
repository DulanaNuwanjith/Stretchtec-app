<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterialStore::class, 'raw_material_store_id');
    }

    public function orderPreparation(): BelongsTo
    {
        return $this->belongsTo(ProductOrderPreperation::class, 'order_preperation_id');
    }
}
