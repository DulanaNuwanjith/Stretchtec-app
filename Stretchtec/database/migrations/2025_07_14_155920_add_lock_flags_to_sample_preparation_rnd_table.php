<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            // Do NOT add is_dev_plan_locked here again
            $table->boolean('is_po_locked')->default(false)->after('yarnOrderedPONumber');
            $table->boolean('is_shade_locked')->default(false)->after('shade');
            $table->boolean('is_qty_locked')->default(false)->after('yarnOrderedQty');
            $table->boolean('is_tkt_locked')->default(false)->after('tkt');
            $table->boolean('is_supplier_locked')->default(false)->after('yarnSupplier');
            $table->boolean('is_deadline_locked')->default(false)->after('productionDeadline');
            $table->boolean('is_reference_locked')->default(false)->after('referenceNo');
        });
    }

    public function down()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->dropColumn([
                'is_po_locked', 'is_shade_locked', 'is_qty_locked', 'is_tkt_locked',
                'is_supplier_locked', 'is_deadline_locked', 'is_reference_locked'
            ]);
        });
    }

};
