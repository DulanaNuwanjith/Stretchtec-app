<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $validatedData)
 * @method static simplePaginate(int $int)
 * @method static selectRaw(string $string)
 * @method static findOrFail($id)
 * @method static where(string $string, $prod_order_no)
 * @method static orderBy(string $string, string $string1)
 * @method static find($order_no)
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
        'production_deadline',
        'deadline_reason',
        'size',
        'item',
        'color',
        'reference_no',
        'supplier',
        'pst_no',
        'supplier_comment',
        'item_description',
        'shade',
        'tkt',
        'qty',
        'uom',
        'unitPrice',
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
        'canSendToProduction',
        'isSentToProduction',
        'sent_to_production_at',
        'status',
        'remarks',
        'order_type',
    ];

    public function stores(): HasMany
    {
        return $this->hasMany(Stores::class, 'order_no');
    }

    public function mailBooking(): HasMany
    {
        return $this->hasMany(Stores::class, 'mail_no');
    }


}
