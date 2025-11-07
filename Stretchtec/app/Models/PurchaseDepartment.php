<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class PurchaseDepartment extends Model
{
    protected $table = 'purchase_departments';

    protected $fillable = [
        'po_number',
        'po_date',
        'shade',
        'color',
        'tkt',
        'pst_no',
        'supplier_comment',
        'uom',
        'quantity',
        'rate',
        'amount',
        'total_amount',
        'status',
    ];
}
