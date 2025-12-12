<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 */
class BraidingSectionOrders extends Model
{
    protected $table = 'braiding_section_orders';

    protected $fillable = [
        'order_preperation_id',
        'product_inquiry_id',
        'mail_booking_id',
        'prod_order_no',
    ];

    /**
     * Relationship: Each braiding section order belongs to one product inquiry.
     */
    public function productInquiry(): BelongsTo
    {
        return $this->belongsTo(ProductInquiry::class, 'product_inquiry_id');
    }

    /**
     * Relationship: Each braiding section order belongs to one mail booking.
     */
    public function mailBooking(): BelongsTo
    {
        return $this->belongsTo(MailBooking::class, 'mail_booking_id');
    }

    /**
     * Relationship: Each braiding section order belongs to one order preparation.
     */
    public function orderPreparation(): BelongsTo
    {
        return $this->belongsTo(ProductOrderPreperation::class, 'order_preperation_id');
    }
}
