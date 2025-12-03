<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $all)
 * @method static select(string $string)
 * @method static whereIn(string $string, $pluck)
 */
class LocalProcurement extends Model
{
    protected $fillable = [
        'date',
        'invoice_number',
        'po_number',
        'supplier_name',
        'color',
        'shade',
        'tkt',
        'uom',
        'quantity',
        'unit_price',
        'total_price',
        'total_quantity',
        'invoice_value',
        'notes',
        'pst_no',
        'supplier_comment',
        'approved_by',
        'status',
    ];

    // Define relationship with PurchaseDepartment
    public function purchaseDepartment(): BelongsTo
    {
        return $this->belongsTo(PurchaseDepartment::class, 'po_number', 'po_number');
    }
}
