<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static where(string $string, $reference_no)
 */
class Stock extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'reference_no',
        'shade',
        'qty_available',
        'notes',
        'uom'
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'qty_available' => 'integer',
    ];
}
