<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * LeftoverYarn Model
 * --------------------------------------------------------------------------
 * Represents the `leftover_yarns` table in the database.
 *
 * This model is responsible for handling leftover yarn stock details,
 * including shade, supplier, PO number, stock availability, and received dates.
 *
 * ✅ Key Points:
 *  - Inherits from Eloquent's base Model.
 *  - Uses `$fillable` to protect against mass assignment vulnerabilities.
 *  - Uses `$casts` to automatically handle date conversions.
 * --------------------------------------------------------------------------
 * @method static create(array $array)
 * @method static findOrFail($id)
 * @method static where(string $string, string $string1, Carbon $subDays)
 */
class LeftoverYarn extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Defines which fields can be bulk-assigned.
     * Protects against mass assignment vulnerabilities.
     *
     * Columns:
     *  - shade → Yarn shade identifier
     *  - po_number → Purchase Order number related to yarn order
     *  - yarn_received_date→ Date the yarn was received
     *  - tkt → TKT (ticket/thread specification)
     *  - yarn_supplier → Supplier name of the yarn
     *  - available_stock → Current available stock (quantity)
     */
    protected $fillable = [
        'shade',                // Yarn Shade
        'po_number',            // Yarn Ordered PO Number
        'yarn_received_date',   // Date when yarn was received
        'tkt',                  // TKT (thread spec)
        'yarn_supplier',        // Supplier of the yarn
        'available_stock',      // Current available stock
    ];

    /**
     * ----------------------------------------------------------------------
     * Attribute Casting
     * ----------------------------------------------------------------------
     * Ensures that `yarn_received_date` is always treated as a `date`
     * when retrieved or stored.
     *
     * Example:
     *   $yarn->yarn_received_date → Carbon instance
     */
    protected $casts = [
        'yarn_received_date' => 'date',
    ];
}
