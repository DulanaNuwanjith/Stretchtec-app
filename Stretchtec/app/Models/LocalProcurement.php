<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
