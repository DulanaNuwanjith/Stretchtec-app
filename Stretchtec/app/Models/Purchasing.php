<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    protected $fillable = [
        'order_no',
        'color',
        'shade',
        'pst_no',
        'tkt',
        'supplier_comment',
        'type',
        'quantity',
        'price',
        'description',
    ];
}

