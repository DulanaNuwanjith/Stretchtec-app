<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static where(string $string, $reference_no)
 * @method static findOrFail($id)
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
}
