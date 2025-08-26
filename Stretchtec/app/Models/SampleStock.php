<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * SampleStock Model
 * --------------------------------------------------------------------------
 * Represents the `sample_stocks` table in the database.
 *
 * This model manages the stock of samples available in the system,
 * including shade, quantity, and any special notes regarding the stock.
 *
 * ✅ Key Points:
 *  - `$fillable` defines attributes that can be mass-assigned.
 *  - Custom route key for model binding using `reference_no`.
 *
 * Example:
 *   $stock = SampleStock::create([
 *       'reference_no' => 'REF123',
 *       'shade' => 'Blue',
 *       'available_stock' => 100,
 *       'special_note' => 'Keep away from sunlight',
 *   ]);
 * --------------------------------------------------------------------------
 */
class SampleStock extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Specifies the fields that can be safely inserted or updated.
     *
     * Includes:
     *  - reference_no → Unique reference number for the sample stock
     *  - shade        → Color/shade of the sample
     *  - available_stock → Current available quantity
     *  - special_note → Optional notes regarding the stock
     */
    protected $fillable = [
        'reference_no',
        'shade',
        'available_stock',
        'special_note',
    ];

    /**
     * ----------------------------------------------------------------------
     * Custom Route Key
     * ----------------------------------------------------------------------
     * Use `reference_no` instead of the default `id` for route model binding.
     *
     * Example in routes:
     *   Route::get('/sample-stock/{sampleStock}', function (SampleStock $sampleStock) {
     *       return $sampleStock;
     *   });
     */
    public function getRouteKeyName()
    {
        return 'reference_no';
    }
}
