<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeftoverYarn extends Model
{
    protected $fillable = [
        'shade',                // Shade
        'po_number',            // Yarn Ordered PO Number
        'yarn_received_date',   // Yarn Received Date
        'tkt',                  // Tkt
        'yarn_supplier',        // Yarn Supplier
        'available_stock',      // Available Stock
    ];

    protected $casts = [
        'yarn_received_date' => 'date',
    ];
}
