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
        Schema::create('export_procurements', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('invoice_number');
            $table->string('supplier');
            $table->string('product_description');
            $table->decimal('net_weight');
            $table->decimal('unit_price');
            $table->decimal('total_amount');
            $table->decimal('total_weight');
            $table->decimal('invoice_value');
            $table->string('checked_by')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_procurements');
    }
};
