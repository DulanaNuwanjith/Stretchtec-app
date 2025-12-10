<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static where(string $string, $reference_no)
 * @method static findOrFail($id)
 * @method static find($id)
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


    public function stores(): HasMany
    {
        return $this->hasMany(Stores::class, 'reference_no', 'reference_no');
    }

    /**
     * Boot method to attach model event listeners
     */
    protected static function booted()
    {
        static::updated(function ($stock) {
            // Delete the stock if qty_available is 0 or less
            if ($stock->qty_available <= 0) {
                $stock->delete();
            }
        });
    }
}
