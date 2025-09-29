<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderPreperation extends Model
{
    protected $fillable = [
        'product_inquiry_id',
        'prod_order_no',
        'customer_name',
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
    public function inquiry()
    {
        return $this->belongsTo(ProductInquiry::class, 'product_inquiry_id');
    }
}
