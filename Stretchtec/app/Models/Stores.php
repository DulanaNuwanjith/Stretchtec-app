<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * --------------------------------------------------------------------------
 * Stores Model
 * --------------------------------------------------------------------------
 * Represents the `stores` table in the database.
 *
 * This is an empty model for now. It can be extended in the future
 * to manage store-related data, including
 *  - Store details (name, location, manager)
 *  - Inventory tracking
 *  - Other store-related functionalities
 *
 * All CRUD operations and relationships can be added as needed.
 *
 * Example usage (future):
 *   $store = Stores::create([
 *       'name' => 'Main Store',
 *       'location' => 'Colombo',
 *   ]);
 * --------------------------------------------------------------------------
 * @method static where(string $string, $reference_no)
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail($id)
 * @property mixed $order_no
 * @property mixed $prod_order_no
 * @property mixed $reference_no
 * @property mixed|null $shade
 * @property int|mixed $qty_available
 * @property int|mixed $qty_allocated
 * @property mixed $assigned_by
 * @property false|mixed $is_qty_assigned
 */
class Stores extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_no',
        'prod_order_no',
        'reference_no',
        'shade',
        'qty_available',
        'qty_allocated',
        'reason_for_reject',
        'assigned_by',
        'is_qty_assigned',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'is_qty_assigned' => 'boolean',
    ];

    /**
     * Relationship: Store belongs to a ProductInquiry (foreign key: order_no).
     */
    public function productInquiry(): BelongsTo
    {
        return $this->belongsTo(ProductInquiry::class, 'prod_order_no');
    }
}
