<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SamplePreparationProduction extends Model
{
    protected $table = 'sample_preparation_production';

    protected $fillable = [
        'sample_preparation_rnd_id',
        'order_no',
        'production_deadline',
        'order_received_at',
        'order_start_at',
        'operator_name',
        'supervisor_name',
        'order_complete_at',
        'production_output',
        'dispatch_to_rnd_at',
        'note',
        'is_output_locked',
        'dispatched_by',
    ];

    protected $casts = [
        'production_deadline'    => 'date',
        'order_received_at'      => 'datetime',
        'order_start_at'         => 'datetime',
        'order_complete_at'      => 'datetime',
        'dispatch_to_rnd_at'     => 'datetime',
    ];

    public function samplePreparationRnD()
    {
        return $this->belongsTo(SamplePreparationRnD::class, 'sample_preparation_rnd_id');
    }
}
