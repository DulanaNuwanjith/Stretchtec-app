<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * SampleInquiry Model
 * --------------------------------------------------------------------------
 * Represents the `sample_inquiries` table in the database.
 *
 * This model is responsible for managing customer sample inquiries
 * including order details, customer information, production timelines,
 * and their linkage to R&D and production processes.
 *
 * ✅ Key Points:
 *  - `$fillable` defines attributes safe for mass assignment.
 *  - `$casts` ensures automatic type conversion (dates, datetime).
 *  - Relationships link inquiries to Sample Preparation RnD,
 *    Product Catalogs, and Production processes.
 *  - `booted()` lifecycle method auto-creates ProductCatalog records
 *    when reference numbers are updated.
 *
 * Example:
 *   $inquiry = SampleInquiry::create([
 *       'orderNo' => 'ORD001',
 *       'customerName' => 'ABC Textiles',
 *       'item' => 'Elastic',
 *       'size' => 'L',
 *       'color' => 'Black',
 *       'sampleQty' => 100,
 *       'inquiryReceiveDate' => now(),
 *   ]);
 * --------------------------------------------------------------------------
 * @method static select(string $string)
 * @method static where(string $string, mixed $orderNo)
 * @method static whereBetween(string $string, array $array)
 * @method static whereNotNull(string $string)
 * @method static findOrFail($id)
 * @method static create(array $array)
 */
class SampleInquiry extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Defines which fields can be bulk assigned during `create()` or `update()`.
     *
     * Includes:
     *  - File references (orderFile, referenceNo, dNoteNumber, notes)
     *  - Order & inquiry details (orderNo, inquiryReceiveDate, item, size, style)
     *  - Customer info (customerName, merchandiseName, coordinatorName, decision)
     *  - Production-related fields (sampleQty, alreadyDeveloped, developPlannedDate)
     *  - Delivery details (customerRequestDate, customerDeliveryDate, deliveryQty)
     *  - Rejections (rejectNO, customerSpecialComment)
     */
    protected $fillable = [
        'orderFile',
        'orderNo',
        'inquiryReceiveDate',
        'customerName',
        'merchandiseName',
        'coordinatorName',
        'item',
        'ItemDiscription',
        'size',
        'qtRef',
        'color',
        'style',
        'sampleQty',
        'customerSpecialComment',
        'customerRequestDate',
        'alreadyDeveloped',
        'sentToSampleDevelopmentDate',
        'developPlannedDate',
        'productionStatus',
        'referenceNo',
        'customerDeliveryDate',
        'dNoteNumber',
        'customerDecision',
        'notes',
        'deliveryQty',
        'rejectNO',
    ];

    /**
     * ----------------------------------------------------------------------
     * Attribute Casting
     * ----------------------------------------------------------------------
     * Automatically converts attributes to proper data types.
     *
     *  - inquiryReceiveDate   → `date`
     *  - customerRequestDate  → `date`
     *  - developPlannedDate   → `date`
     *  - customerDeliveryDate → `datetime`
     */
    protected $casts = [
        'inquiryReceiveDate' => 'date',
        'customerRequestDate' => 'date',
        'developPlannedDate' => 'date',
        'customerDeliveryDate' => 'datetime',
    ];

    /* ======================================================================
     * RELATIONSHIPS
     * ======================================================================
     */

    /**
     * Each inquiry has one Sample Preparation RnD entry.
     */
    public function samplePreparationRnD()
    {
        return $this->hasOne(SamplePreparationRnD::class);
    }

    /**
     * Each inquiry can be linked to one Product Catalog.
     */
    public function productCatalog()
    {
        return $this->hasOne(ProductCatalog::class);
    }

    /**
     * Each inquiry can be linked through SamplePreparationRnD
     * to a Sample Preparation Production record.
     *
     * Uses a `hasOneThrough` relationship for indirect linkage.
     */
    public function samplePreparationProduction()
    {
        return $this->hasOneThrough(
            SamplePreparationProduction::class,
            SamplePreparationRnD::class,
            'sample_inquiry_id',         // Foreign key on sample_preparation_rnd
            'sample_preparation_rnd_id', // Foreign key on sample_preparation_production
            'id',                        // Local key on sample_inquiries
            'id'                         // Local key on sample_preparation_rnd
        );
    }

    /* ======================================================================
     * MODEL EVENTS
     * ======================================================================
     */

    /**
     * Lifecycle Hook: booted()
     * ----------------------------------------------------------------------
     * Runs when the model is "booted".
     * Logic: When `referenceNo` is updated, and if it has a linked
     * SamplePreparationRnD entry (that isn't marked "No Need to Develop"),
     * a corresponding ProductCatalog record is automatically created.
     */
    protected static function booted()
    {
        static::updated(function ($inquiry) {
            if (
                $inquiry->isDirty('referenceNo') &&
                !empty($inquiry->referenceNo) &&
                !$inquiry->productCatalog
            ) {
                $rnd = $inquiry->samplePreparationRnD;

                // Ensure the RnD entry exists and requires development
                if ($rnd && $rnd->alreadyDeveloped !== 'No Need to Develop') {
                    ProductCatalog::create([
                        'order_no' => $inquiry->orderNo,
                        'reference_no' => $inquiry->referenceNo,
                        'reference_added_date' => now(),
                        'coordinator_name' => $inquiry->coordinatorName,
                        'item' => $inquiry->item,
                        'size' => $inquiry->size,
                        'colour' => $inquiry->color,
                        'shade' => $rnd->shade,
                        'tkt' => $rnd->tkt,
                        'sample_inquiry_id' => $inquiry->id,
                        'sample_preparation_rnd_id' => $rnd->id,
                        'supplier' => $rnd->yarnSupplier,
                        'pst_no' => $rnd->pst_no,
                    ]);
                }
            }
        });
    }
}
