<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BraidingSectionOrders extends Model
{
    protected $table = 'braiding_section_orders';

    protected $fillable = [
        'order_preperation_id',
        'product_inquiry_id',
        'prod_order_no',
    ];
}
