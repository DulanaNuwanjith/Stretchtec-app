<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShadeOrder extends Model
{
    protected $fillable = [
        'sample_preparation_rnd_id',
        'shade',
        'status',
        'yarn_receive_date',
    ];

    // App\Models\ShadeOrder.php
    public function productCatalogs()
    {
        return $this->belongsTo(ProductCatalog::class, 'sample_preparation_rnd_id', 'sample_preparation_rnd_id');
    }

}
