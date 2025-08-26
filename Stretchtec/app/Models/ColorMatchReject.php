<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * ColorMatchReject Model
 * --------------------------------------------------------------------------
 * Represents the `color_match_rejects` table in the database.
 *
 * This model is responsible for handling data related to color match rejects,
 * including when a sample was sent, received, or rejected, and the reason
 * behind the rejection.
 *
 * ✅ Key Points:
 *  - Inherits from Eloquent's base Model.
 *  - Uses `$fillable` to protect against mass assignment vulnerabilities.
 *  - Uses `$casts` to automatically handle date/datetime conversions.
 *  - Defines a relationship with the `SampleInquiry` model.
 * --------------------------------------------------------------------------
 */
class ColorMatchReject extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Database Table Mapping
     * ----------------------------------------------------------------------
     * By default, Laravel assumes the table name is the plural of the model
     * (i.e., `color_match_rejects`). Here it is explicitly declared for clarity.
     */
    protected $table = 'color_match_rejects';

    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * These attributes can be bulk-assigned when creating/updating records.
     * Helps prevent mass assignment vulnerabilities.
     */
    protected $fillable = [
        'orderNo',
        'sentDate',
        'receiveDate',
        'rejectDate',
        'rejectReason',
    ];

    /**
     * ----------------------------------------------------------------------
     * Attribute Casting
     * ----------------------------------------------------------------------
     * Automatically converts database fields into proper PHP data types.
     * For example:
     *   - `sentDate` => Carbon instance (datetime)
     *   - `receiveDate` => Carbon instance (datetime)
     *   - `rejectDate` => Carbon instance (datetime)
     */
    protected $casts = [
        'sentDate' => 'datetime',
        'receiveDate' => 'datetime',
        'rejectDate' => 'datetime',
    ];

    /**
     * ----------------------------------------------------------------------
     * Relationships
     * ----------------------------------------------------------------------
     * A ColorMatchReject belongs to a SampleInquiry.
     *
     * Linking is done via `orderNo`:
     *  - `color_match_rejects.orderNo` → `sample_inquiries.orderNo`
     *
     * This allows us to retrieve the associated inquiry for each rejection.
     */
    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class, 'orderNo', 'orderNo');
    }
}
