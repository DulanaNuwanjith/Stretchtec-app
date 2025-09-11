<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * --------------------------------------------------------------------------
 * OperatorsandSupervisors Model
 * --------------------------------------------------------------------------
 * Represents the `operatorsand_supervisors` table in the database.
 *
 * This model is responsible for storing and managing information about
 * operators and supervisors within the system.
 *
 * ✅ Key Points:
 *  - Explicitly maps to the `operatorsand_supervisors` table.
 *  - Uses `$fillable` to define safe attributes for mass assignment.
 *  - `$timestamps = true` ensures `created_at` and `updated_at` fields
 *    are automatically managed by Laravel.
 *
 * Example:
 *   $employee = OperatorsandSupervisors::create([
 *       'empID'   => 'EMP001',
 *       'name'    => 'John Doe',
 *       'phoneNo' => '0711234567',
 *       'address' => 'Colombo, Sri Lanka',
 *       'role'    => 'Supervisor',
 *   ]);
 * --------------------------------------------------------------------------
 * @method static where(string $string, string $string1)
 * @method static create(array $array)
 * @method static orderBy(string $string, string $string1)
 * @method static findOrFail($id)
 */
class OperatorsandSupervisors extends Model
{
    /**
     * ----------------------------------------------------------------------
     * Table Mapping
     * ----------------------------------------------------------------------
     * Explicitly defines the database table used by this model.
     * Laravel would normally infer the table name, but since this is
     * a compound name, we define it explicitly for clarity.
     */
    protected $table = 'operatorsand_supervisors';

    /**
     * ----------------------------------------------------------------------
     * Mass-Assignable Attributes
     * ----------------------------------------------------------------------
     * Defines which attributes are safe to be mass assigned.
     *
     * Columns:
     *  - empID   → Employee ID
     *  - name    → Full name of the operator/supervisor
     *  - phoneNo → Contact number
     *  - address → Residential address
     *  - role    → Role designation (e.g., Operator, Supervisor)
     */
    protected $fillable = [
        'empID',
        'name',
        'phoneNo',
        'address',
        'role',
    ];

    /**
     * ----------------------------------------------------------------------
     * Timestamps
     * ----------------------------------------------------------------------
     * Ensures `created_at` and `updated_at` columns are automatically
     * managed by Eloquent when creating or updating records.
     */
    public $timestamps = true;
}
