<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validatedData)
 * @method static simplePaginate(int $int)
 * @method static selectRaw(string $string)
 * @method static findOrFail($id)
 */
class ProductInquiry extends Model
{
    protected $fillable = [
        'prod_order_no',
        'po_received_date',
        'customer_name',
        'merchandiser_name',
        'customer_coordinator',
        'po_number',
        'size',
        'item',
        'color',
        'reference_no',
        'supplier',
        'pst_no',
        'supplier_comment',
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
        'sent_to_stock_at',
        'isSentToProduction',
        'sent_to_production_at',
        'status',
        'remarks',
    ];
}
