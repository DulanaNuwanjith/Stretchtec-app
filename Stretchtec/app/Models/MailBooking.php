<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static selectRaw(string $string)
 * @method static create(array $array)
 * @method static findOrFail($id)
 * @method static where(string $string, $mail_booking_no)
 * @method static find($mail_no)
 */
class MailBooking extends Model
{
    protected $fillable = [
        'mail_booking_number',
        'order_received_date',
        'customer_name',
        'customer_coordinator',
        'merchandiser_name',
        'email',
        'size',
        'item',
        'color',
        'reference_no',
        'shade',
        'tkt',
        'qty',
        'uom',
        'supplier',
        'pst_no',
        'supplier_comment',
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
        'isApproved',
        'approved_by',
        'approved_at',
        'isSentToStock',
        'sent_to_stock_at',
        'canSendToProduction',
        'isSentToProduction',
        'sent_to_production_at',
        'status',
        'remarks',
    ];

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Stores::class, 'mail_no', 'id');
    }
}
