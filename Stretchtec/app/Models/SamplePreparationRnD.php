<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * SamplePreparationRnD Model
 * --------------------------------------------------------------------------
 * Represents the `sample_preparation_rnd` table in the database.
 *
 * This model manages the **Research & Development (RnD)** stage of the
 * sample preparation process, including:
 *  - Planning (development plans, deadlines, reference numbers)
 *  - Yarn ordering & supplier details
 *  - Shade and Tkt details
 *  - Colour matching timelines
 *  - Locking mechanisms to prevent accidental overwrites
 *  - Linking back to the original customer inquiry
 *
 * ✅ Key Points:
 *  - `$fillable` defines the attributes that can be mass-assigned.
 *  - `$casts` ensures automatic type conversions (dates, booleans, strings).
 *  - Relationships:
 *      • BelongsTo → `SampleInquiry`
 *      • HasOne → `SamplePreparationProduction`
 *      • HasMany → `ShadeOrder`
 *  - Boot Logic: Keeps `SampleInquiry` synchronized when `referenceNo`
 *    or `developPlannedDate` are updated in RnD.
 *
 * Example:
 *   $rnd = SamplePreparationRnD::create([
 *       'sample_inquiry_id' => 1,
 *       'orderNo' => 'ORD1001',
 *       'developPlannedDate' => '2025-09-01',
 *       'shade' => 'Navy Blue',
 *       'tkt' => '40',
 *       'yarnSupplier' => 'ABC Textiles',
 *   ]);
 * --------------------------------------------------------------------------
 * @method static where(string $string, mixed $orderNo)
 * @method static whereBetween(string $string, array $array)
 * @method static whereNotNull(string $string)
 * @method static findOrFail(mixed $id)
 * @method static create(array $array)
 * @method static distinct()
 */
class SamplePreparationRnD extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Table Name
     * ----------------------------------------------------------------------
     * Explicitly maps to the `sample_preparation_rnd` table.
     */
    protected $table = 'sample_preparation_rnd';

    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Defines which fields can be safely inserted or updated.
     *
     * Includes:
     *  - Foreign Key: sample_inquiry_id
     *  - Order details: orderNo, referenceNo
     *  - Planning: customerRequestDate, developPlannedDate, productionDeadline
     *  - Yarn details: yarnOrderedDate, yarnSupplier, yarnPrice, yarnReceiveDate
     *  - Colour matching: colourMatchSentDate, colourMatchReceiveDate
     *  - Shade/Tkt details with locking fields
     *  - Output tracking: productionOutput, yarnOrderedWeight, yarnLeftoverWeight
     *  - Lock flags to prevent unwanted changes
     */
    protected $fillable = [
        'sample_inquiry_id',
        'orderNo',
        'customerRequestDate',
        'developPlannedDate',
        'is_dev_plan_locked',
        'colourMatchSentDate',
        'colourMatchReceiveDate',
        'yarnOrderedDate',
        'yarnOrderedPONumber',
        'is_po_locked',
        'shade',
        'is_shade_locked',
        'tkt',
        'is_tkt_locked',
        'yarnSupplier',
        'yarnPrice',
        'is_supplier_locked',
        'yarnReceiveDate',
        'productionDeadline',
        'is_deadline_locked',
        'sendOrderToProductionStatus',
        'productionStatus',
        'referenceNo',
        'is_reference_locked',
        'productionOutput',
        'note',
        'alreadyDeveloped',
        'yarnOrderedWeight',
        'is_yarn_ordered_weight_locked',
        'yarnLeftoverWeight',
        'is_yarn_leftover_weight_locked',
    ];

    /**
     * ----------------------------------------------------------------------
     * Attribute Casting
     * ----------------------------------------------------------------------
     * Automatically converts fields into proper PHP types.
     *
     * - Dates & Datetimes: customerRequestDate, developPlannedDate,
     *   colourMatchSentDate, colourMatchReceiveDate, yarnOrderedDate,
     *   yarnReceiveDate, productionDeadline, sendOrderToProductionStatus
     * - Booleans: Lock flags
     * - Strings: alreadyDeveloped
     */
    protected $casts = [
        'customerRequestDate' => 'date',
        'developPlannedDate' => 'date',
        'colourMatchSentDate' => 'datetime',
        'colourMatchReceiveDate' => 'datetime',
        'yarnOrderedDate' => 'datetime',
        'yarnReceiveDate' => 'datetime',
        'productionDeadline' => 'date',
        'sendOrderToProductionStatus' => 'datetime',
        'is_dev_plan_locked' => 'boolean',
        'is_po_locked' => 'boolean',
        'is_shade_locked' => 'boolean',
        'is_tkt_locked' => 'boolean',
        'is_supplier_locked' => 'boolean',
        'is_deadline_locked' => 'boolean',
        'is_reference_locked' => 'boolean',
        'alreadyDeveloped' => 'string',
        'is_yarn_ordered_weight_locked' => 'boolean',
        'is_yarn_leftover_weight_locked' => 'boolean',
    ];

    /* ======================================================================
     * RELATIONSHIPS
     * ======================================================================
     */

    /**
     * Belongs To → Sample Inquiry
     * Links each RnD preparation to its parent inquiry.
     */
    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class, 'sample_inquiry_id');
    }

    /**
     * Has One → Production
     * Each RnD record can lead to one production entry.
     */
    public function production()
    {
        return $this->hasOne(SamplePreparationProduction::class, 'sample_preparation_rnd_id');
    }

    /**
     * Has Many → Shade Orders
     * One RnD record can be linked with multiple shade orders.
     */
    public function shadeOrders()
    {
        return $this->hasMany(ShadeOrder::class, 'sample_preparation_rnd_id');
    }

    /* ======================================================================
     * BOOT LOGIC (Model Events)
     * ======================================================================
     */

    /**
     * Booted: Automatically keeps related `SampleInquiry` in sync.
     * ----------------------------------------------------------------------
     * When this model is saved:
     *  - If `referenceNo` changes → Updates inquiry's referenceNo.
     *  - If `developPlannedDate` changes → Updates inquiry's developPlannedDate.
     */
    protected static function booted()
    {
        static::saved(function ($prep) {
            if ($prep->sampleInquiry && ($prep->isDirty('referenceNo') || $prep->isDirty('developPlannedDate'))) {
                $updateData = [];

                if ($prep->isDirty('referenceNo')) {
                    $updateData['referenceNo'] = $prep->referenceNo;
                }

                if ($prep->isDirty('developPlannedDate')) {
                    $updateData['developPlannedDate'] = $prep->developPlannedDate;
                }

                if (!empty($updateData)) {
                    $prep->sampleInquiry->update($updateData);
                }
            }
        });
    }
}
