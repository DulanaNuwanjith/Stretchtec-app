<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 * @method static create(array $array)
 * @method static findOrFail($id)
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
    ];

    // Optional: link back to ProductInquiry
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(ProductInquiry::class, 'product_inquiry_id');
    }
}
