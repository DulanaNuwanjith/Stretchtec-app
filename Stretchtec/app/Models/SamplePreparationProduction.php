<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * SamplePreparationProduction Model
 * --------------------------------------------------------------------------
 * Represents the `sample_preparation_production` table in the database.
 *
 * This model manages production-related data after R&D approval,
 * including deadlines, start/end dates, operators, supervisors,
 * production output, and dispatch information.
 *
 * ✅ Key Points:
 *  - `$fillable` → Defines safe attributes for mass assignment.
 *  - `$casts` → Automatically converts dates & timestamps.
 *  - Relationships → Connects to Sample Preparation RnD and Inquiry.
 *  - Includes an accessor (`getOrderFileUrlAttribute`) to fetch
 *    the linked order file path for easy Blade template usage.
 *
 * Example:
 *   $production = SamplePreparationProduction::create([
 *       'sample_preparation_rnd_id' => 1,
 *       'order_no' => 'ORD123',
 *       'production_deadline' => '2025-09-01',
 *       'operator_name' => 'John Doe',
 *       'supervisor_name' => 'Jane Smith',
 *       'production_output' => 1200,
 *       'damaged_output' => 50,
 *   ]);
 * --------------------------------------------------------------------------
 * @method static where(string $string, mixed $orderNo)
 * @method static firstOrNew(array $array)
 * @method static findOrFail(mixed $id)
 */
class SamplePreparationProduction extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Table Name
     * ----------------------------------------------------------------------
     * Explicitly maps to `sample_preparation_production`.
     */
    protected $table = 'sample_preparation_production';

    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Defines which fields can be safely inserted or updated.
     *
     * Includes:
     *  - Foreign Keys (sample_preparation_rnd_id, order_no)
     *  - Timeline fields (production_deadline, order_received_at,
     *    order_start_at, order_complete_at, dispatch_to_rnd_at)
     *  - Roles (operator_name, supervisor_name, dispatched_by)
     *  - Production data (production_output, damaged_output)
     *  - Notes (note)
     *  - Locking (is_output_locked → prevents editing after approval)
     */
    protected $fillable = [
        'sample_preparation_rnd_id',
        'order_no',
        'production_deadline',
        'order_received_at',
        'order_start_at',
        'operator_name',
        'supervisor_name',
        'order_complete_at',
        'production_output',
        'damaged_output',
        'dispatch_to_rnd_at',
        'note',
        'is_output_locked',
        'dispatched_by',
    ];

    /**
     * ----------------------------------------------------------------------
     * Attribute Casting
     * ----------------------------------------------------------------------
     * Automatically converts database fields into proper PHP types.
     *
     *  - production_deadline → `date`
     *  - order_received_at   → `datetime`
     *  - order_start_at      → `datetime`
     *  - order_complete_at   → `datetime`
     *  - dispatch_to_rnd_at  → `datetime`
     */
    protected $casts = [
        'production_deadline' => 'date',
        'order_received_at' => 'datetime',
        'order_start_at' => 'datetime',
        'order_complete_at' => 'datetime',
        'dispatch_to_rnd_at' => 'datetime',
    ];

    /* ======================================================================
     * RELATIONSHIPS
     * ======================================================================
     */

    /**
     * Belongs To → Sample Preparation RnD
     * Each production entry is linked to one RnD preparation.
     */
    public function samplePreparationRnD()
    {
        return $this->belongsTo(SamplePreparationRnD::class, 'sample_preparation_rnd_id');
    }

    /**
     * Belongs To → Sample Inquiry
     * Links production back to the inquiry using `order_no`.
     * Adjusts foreign keys if inquiry keys differ.
     */
    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class, 'order_no', 'orderNo');
    }

    /* ======================================================================
     * ACCESSORS
     * ======================================================================
     */

    /**
     * Accessor: getOrderFileUrlAttribute
     * ----------------------------------------------------------------------
     * Returns the full URL to the order file uploaded with the inquiry.
     * If no file exists, returns `null`.
     *
     * Usage Example in Blade:
     *   <a href="{{ $production->order_file_url }}">Download File</a>
     */
    public function getOrderFileUrlAttribute()
    {
        return $this->samplePreparationRnD?->sampleInquiry?->orderFile
            ? asset('storage/' . $this->samplePreparationRnD->sampleInquiry->orderFile)
            : null;
    }
}
