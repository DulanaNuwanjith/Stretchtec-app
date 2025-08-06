<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sample_preparation_rnd_id',
        'sample_inquiry_id',
        'order_no',
        'reference_no',
        'reference_added_date',
        'coordinator_name',
        'item',
        'size',
        'colour',
        'shade',
        'tkt',
        'order_image',
        'approved_by',
        'approval_card',
        'is_approved_by_locked',
        'is_approval_card_locked',
    ];

    protected $casts = [
        'reference_added_date' => 'date',
        'is_approved_by_locked' => 'boolean',
        'is_approval_card_locked' => 'boolean',
    ];

    // Relationships
    public function samplePreparationRnD()
    {
        return $this->belongsTo(SamplePreparationRnD::class);
    }

    public function sampleInquiry()
    {
        return $this->belongsTo(SampleInquiry::class);
    }
}
