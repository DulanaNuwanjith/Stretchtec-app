<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorsandSupervisors extends Model
{
    protected $table = 'operatorsand_supervisors';

    protected $fillable = [
        'empID',
        'name',
        'phoneNo',
        'address',
        'role',
    ];

    public $timestamps = true;
}
