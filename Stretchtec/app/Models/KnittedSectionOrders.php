<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnittedSectionOrders extends Model
{
    protected $table = 'knitted_section_orders';

    protected $fillable = [
        'order_preperation_id',
        'product_inquiry_id',
        'prod_order_no',
    ];
}
