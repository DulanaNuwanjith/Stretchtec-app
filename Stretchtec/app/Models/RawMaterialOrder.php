<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawMaterialOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'color',
        'shade',
        'pst_no',
        'tkt',
        'supplier_comment',
        'qty',
        'kg_or_cone',
        'price',
        'description',
    ];
}
