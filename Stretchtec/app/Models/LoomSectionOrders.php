<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoomSectionOrders extends Model
{
    protected $table = 'loom_section_orders';

    protected $fillable = [
        'order_preperation_id',
        'product_inquiry_id',
        'prod_order_no',
    ];
}
