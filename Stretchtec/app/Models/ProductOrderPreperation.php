<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 * @method static create(array $array)
 * @method static findOrFail($id)
 * @method static where(string $string, false $false)
 */
class ProductOrderPreperation extends Model
{
    protected $fillable = [
        'product_inquiry_id',
        'prod_order_no',
        'customer_name',
        'reference_no',
        'item',
        'size',
        'color',
        'shade',
        'tkt',
        'qty',
        'uom',
        'supplier',
        'pst_no',
        'supplier_comment',
        'status',
        'isRawMaterialOrdered',
        'raw_material_ordered_date',
        'isRawMaterialReceived',
        'raw_material_received_date',
        'isOrderAssigned',
        'order_assigned_date',
        'orderAssignedTo',
    ];

    // Optional: link back to ProductInquiry
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(ProductInquiry::class, 'product_inquiry_id');
    }
}
