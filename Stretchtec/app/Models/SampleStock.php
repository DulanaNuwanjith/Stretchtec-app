<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleStock extends Model
{
    protected $fillable = [
        'reference_no',
        'shade',
        'available_stock',
        'special_note',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference_no';
    }
}
