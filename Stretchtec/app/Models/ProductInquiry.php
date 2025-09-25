<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInquiry extends Model
{
    protected $fillable = [
        'prod_order_no',
        'po_received_date',
        'customer_name',
        'merchandiser_name',
        'po_number',
        'size',
        'item',
        'color',
        'reference_no',
        'shade',
        'tkt',
        'qty',
        'uom',
        'price',
        'customer_req_date',
        'our_prod_date',
        'stock_qty',
        'to_make_qty',
        'delivered_qty',
        'in_production_qty',
        'balance_qty',
        'invoice_no',
        'invoice_date',
        'isSentToStock',
        'isSentToProduction',
        'status',
        'remarks',
    ];
}
