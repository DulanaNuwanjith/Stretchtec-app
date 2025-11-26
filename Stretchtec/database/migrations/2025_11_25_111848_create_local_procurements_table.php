<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('local_procurements', static function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('invoice_number');
            $table->string('po_number');
            $table->string('supplier_name');
            $table->string('color');
            $table->string('shade');
            $table->string('tkt');
            $table->string('uom');
            $table->decimal('quantity');
            $table->decimal('unit_price');
            $table->decimal('total_price');
            $table->string('pst_no')->nullable();
            $table->string('supplier_comment')->nullable();
            $table->decimal('total_quantity');
            $table->decimal('invoice_value');
            $table->string('approved_by')->nullable();
            $table->string('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_procurements');
    }
};
