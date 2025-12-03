<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Log;

/**
 * --------------------------------------------------------------------------
 * SampleInquiry Model
 * --------------------------------------------------------------------------
 * Represents the `sample_inquiries` table in the database.
 *
 * This model is responsible for managing customer sample inquiries,
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
 * @method static distinct()
 * @method static whereIn(string $string, string[] $array)
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
        'po_identification',
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
     *  - inquiryReceiveDate → `date`
     *  - customerRequestDate → `date`
     *  - developPlannedDate → `date`
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
    public function samplePreparationRnD(): HasOne
    {
        return $this->hasOne(SamplePreparationRnD::class);
    }

    /**
     * Each inquiry can be linked to one Product Catalog.
     */
    public function productCatalog(): HasOne
    {
        return $this->hasOne(ProductCatalog::class);
    }

    /**
     * Each inquiry can be linked through SamplePreparationRnD
     * to a Sample Preparation Production record.
     *
     * Uses a `hasOneThrough` relationship for indirect linkage.
     */
    public function samplePreparationProduction(): HasOneThrough
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
    protected static function booted(): void
    {
        static::updated(function ($inquiry) {

            if (empty($inquiry->referenceNo) || !$inquiry->isDirty('referenceNo')) {
                return;
            }

            try {
                $rnd = $inquiry->samplePreparationRnD;

                if (!$rnd || $rnd->alreadyDeveloped === 'No Need to Develop') {
                    return;
                }

                $shade = trim($rnd->shade ?? '');
                $isShadeSelected = ($shade !== '' && strpos($shade, ',') === false);

                // --- Prevent duplicate ProductCatalog entries ---
                $existing = ProductCatalog::where('reference_no', $inquiry->referenceNo)
                    ->where('item', $inquiry->item)
                    ->where('size', $inquiry->size)
                    ->where('shade', $rnd->shade)
                    ->where('supplier', $rnd->yarnSupplier)
                    ->where('tkt', $rnd->tkt)
                    ->where('pst_no', $rnd->pst_no)
                    ->first();

                if (!$existing) {
                    ProductCatalog::create([
                        'order_no' => $inquiry->orderNo,
                        'reference_no' => $inquiry->referenceNo,
                        'reference_added_date' => now(),
                        'coordinator_name' => $inquiry->coordinatorName,
                        'item' => $inquiry->item,
                        'size' => $inquiry->size,
                        'colour' => $inquiry->color,
                        'shade' => $rnd->shade,
                        'supplierComment' => $rnd->supplierComment,
                        'tkt' => $rnd->tkt,
                        'sample_inquiry_id' => $inquiry->id,
                        'sample_preparation_rnd_id' => $rnd->id,
                        'supplier' => $rnd->yarnSupplier,
                        'pst_no' => $rnd->pst_no,
                        'isShadeSelected' => $isShadeSelected,
                    ]);
                }

            } catch (\Throwable $e) {
                Log::error('Error creating ProductCatalog: ' . $e->getMessage(), [
                    'inquiry_id' => $inquiry->id,
                    'referenceNo' => $inquiry->referenceNo,
                ]);
            }

        });
    }
}
