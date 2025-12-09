<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoomSectionOrders extends Model
{
    protected $table = 'loom_section_orders';

    protected $fillable = [
        'order_preperation_id',
        'product_inquiry_id',
        'prod_order_no',
    ];

    /**
     * Relationship: Each loom section order belongs to one product inquiry.
     */
    public function productInquiry(): BelongsTo
    {
        return $this->belongsTo(ProductInquiry::class, 'product_inquiry_id');
    }

    /**
     * Relationship: Each loom section order belongs to one order preparation.
     */
    public function orderPreparation(): BelongsTo
    {
        return $this->belongsTo(ProductOrderPreperation::class, 'order_preperation_id');
    }
}
