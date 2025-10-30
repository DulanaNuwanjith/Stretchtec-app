<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static findOrFail($id)
 * @method static orderBy(string $string, string $string1)
 */
class MailBookingApproval extends Model
{
    protected $fillable = [
        'mail_booking_id',
        'remarks',
    ];

    //Relationship with MailBooking
    public function mailBooking(): BelongsTo
    {
        return $this->belongsTo(MailBooking::class);
    }
}
