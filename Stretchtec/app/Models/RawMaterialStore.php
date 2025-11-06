<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterialStore extends Model
{
    protected $fillable = [
        'color',
        'shade',
        'tkt',
        'supplier',
        'available_quantity',
        'unit',
        'unit_price',
        'remarks',
    ];
}
