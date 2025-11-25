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
        Schema::create('export_raw_materials', static function (Blueprint $table) {
            $table->id();
            $table->string('supplier');
            $table->string('product_description');
            $table->decimal('net_weight');
            $table->decimal('unit_price');
            $table->decimal('total_amount');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
