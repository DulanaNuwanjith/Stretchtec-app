<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate(int $int)
 * @method static create(array $validated)
 * @method static findOrFail($id)
 */
class RawMaterialStore extends Model
{
    protected $fillable = [
        'color',
        'shade',
        'tkt',
        'pst_no',
        'supplier',
        'available_quantity',
        'unit',
        'remarks',
    ];
}
