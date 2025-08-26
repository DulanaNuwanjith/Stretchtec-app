<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * ShadeOrder Model
 * --------------------------------------------------------------------------
 * Represents individual shade orders associated with a Sample Preparation RnD record.
 *
 * This model keeps track of:
 *  - Shade requested and its current status
 *  - Yarn receipt and PST number
 *  - Production output and damaged quantities
 *  - Dispatch and delivery timelines
 *
 * ✅ Key Points:
 *  - `$fillable` defines attributes allowed for mass-assignment.
 *  - Relationship connects each shade order to its corresponding ProductCatalogs
 *    through the `sample_preparation_rnd_id`.
 *
 * Example:
 *   $shadeOrder = ShadeOrder::create([
 *       'sample_preparation_rnd_id' => 1,
 *       'shade' => 'Red',
 *       'status' => 'Pending',
 *       'yarn_receive_date' => now(),
 *       'pst_no' => 'PST123',
 *   ]);
 * --------------------------------------------------------------------------
 */
class ShadeOrder extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Specifies the fields that can be safely inserted or updated.
     *
     * Includes:
     *  - sample_preparation_rnd_id → Foreign key linking to SamplePreparationRnD
     *  - shade → Shade for this order
     *  - status → Current status of the shade order
     *  - yarn_receive_date → Date when yarn was received
     *  - pst_no → PST number for the shade
     *  - production_output → Produced quantity
     *  - damaged_output → Damaged quantity
     *  - dispatched_by → Name of the person who dispatched
     *  - delivered_date → When it was delivered to customer
     *  - production_complete_date → Completion date for production
     *  - dispatched_date → Date dispatched
     */
    protected $fillable = [
        'sample_preparation_rnd_id',
        'shade',
        'status',
        'yarn_receive_date',
        'pst_no',
        'production_output',
        'damaged_output',
        'dispatched_by',
        'delivered_date',
        'production_complete_date',
        'dispatched_date',
    ];

    /* ======================================================================
     * RELATIONSHIPS
     * ======================================================================
     */

    /**
     * Belongs To → ProductCatalog
     * Connects this shade order to its corresponding product catalogs
     * through the `sample_preparation_rnd_id`.
     */
    public function productCatalogs()
    {
        return $this->belongsTo(ProductCatalog::class, 'sample_preparation_rnd_id', 'sample_preparation_rnd_id');
    }
}
