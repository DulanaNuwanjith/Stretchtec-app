<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * --------------------------------------------------------------------------
 * ProductCatalog Model
 * --------------------------------------------------------------------------
 * Represents the `product_catalogs` table in the database.
 *
 * This model is responsible for storing details of product catalogs such as
 * references, orders, approvals, and relationships to sample preparation
 * and inquiries.
 *
 * ✅ Key Points:
 *  - Uses the `HasFactory` trait → Enables factory-based seeding for testing.
 *  - `$fillable` → Defines which fields are safe for mass assignment.
 *  - `$casts` → Automatically converts fields into proper data types.
 *  - Relationships → Connects to Sample Preparation (RnD), Sample Inquiry,
 *    and Shade Orders.
 *
 * Example:
 *   $catalog = ProductCatalog::create([
 *       'order_no' => 'ORD123',
 *       'reference_no' => 'REF456',
 *       'item' => 'Elastic Band',
 *       'size' => 'M',
 *       'color' => 'Blue',
 *       'shade' => 'Shade A',
 *       'tkt' => 'TKT-12',
 *       'supplier' => 'ABC Suppliers',
 *       'reference_added_date' => now(),
 *   ]);
 * --------------------------------------------------------------------------
 * @method static where(string $string, mixed $orderNo)
 * @method static create(array $data)
 * @method static findOrFail($id)
 * @method static find(mixed $sample_id)
 * @property mixed $order_image
 * @property mixed $reference_no
 * @property mixed $is_approved_by_locked
 * @property mixed $is_approval_card_locked
 * @property mixed $approval_card
 * @property mixed $shade
 * @property mixed|true $isShadeSelected
 */
class ProductCatalog extends Model
{
    use HasFactory;

    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * These fields can be bulk-inserted or updated via `create()` or `update()`.
     *
     * Columns:
     *  - sample_preparation_rnd_id  → Foreign key linking to Sample Preparation RnD
     *  - sample_inquiry_id          → Foreign key linking to Sample Inquiry
     *  - order_no                   → Unique order number
     *  - reference_no               → Customer / internal reference number
     *  - reference_added_date       → Date when reference was added
     *  - coordinator_name           → Name of the customer coordinator
     *  - item                       → Item type (e.g., Elastic, Tape)
     *  - size                       → Item size
     *  - color → Item color
     *  - shade                      → Shade name/number
     *  - tkt                        → Ticket number for yarn
     *  - order_image                → Path to uploaded image of the order
     *  - approved_by                → Name of approver
     *  - approval_card              → Card/reference used for approval
     *  - is_approved_by_locked      → Whether the approver field is locked
     *  - is_approval_card_locked    → Whether the approval card field is locked
     *  - supplier                   → Supplier of the product
     *  - pst_no                     → PST number
     */
    protected $fillable = [
        'sample_preparation_rnd_id',
        'sample_inquiry_id',
        'order_no',
        'reference_no',
        'reference_added_date',
        'coordinator_name',
        'item',
        'size',
        'colour',
        'shade',
        'supplierComment',
        'tkt',
        'order_image',
        'approved_by',
        'approval_card',
        'is_approved_by_locked',
        'is_approval_card_locked',
        'supplier',
        'pst_no',
    ];

    /**
     * ----------------------------------------------------------------------
     * Attribute Casting
     * ----------------------------------------------------------------------
     * Ensures attributes are automatically converted to appropriate
     * data types when accessed.
     *
     *  - reference_added_date   → Cast to `date` (Carbon instance).
     *  - is_approved_by_locked  → Cast to `boolean` (true/false).
     *  - is_approval_card_locked→ Cast to `boolean` (true/false).
     */
    protected $casts = [
        'reference_added_date' => 'date',
        'is_approved_by_locked' => 'boolean',
        'is_approval_card_locked' => 'boolean',
    ];

    /* ======================================================================
     * RELATIONSHIPS
     * ======================================================================
     * Defines how ProductCatalog connects with other models in the system.
     */

    /**
     * ----------------------------------------------------------------------
     * Sample Preparation (RnD)
     * ----------------------------------------------------------------------
     * Each ProductCatalog belongs to a single Sample Preparation RnD entry.
     * This ties product catalog data back to RnD details.
     */
    public function samplePreparationRnD(): BelongsTo
    {
        return $this->belongsTo(SamplePreparationRnD::class);
    }

    /**
     * ----------------------------------------------------------------------
     * Sample Inquiry
     * ----------------------------------------------------------------------
     * Each ProductCatalog can be linked to a single Sample Inquiry.
     * This allows tracking of customer requests tied to the catalog.
     */
    public function sampleInquiry(): BelongsTo
    {
        return $this->belongsTo(SampleInquiry::class);
    }

    /**
     * ----------------------------------------------------------------------
     * Shade Orders
     * ----------------------------------------------------------------------
     * A ProductCatalog can have many Shade Orders associated with it.
     * This is mapped using `sample_preparation_rnd_id`.
     */
    public function shadeOrders(): HasMany
    {
        return $this->hasMany(ShadeOrder::class, 'sample_preparation_rnd_id', 'sample_preparation_rnd_id');
    }
}
