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
        Schema::create('assigned_raw_materials', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_preperation_id');
            $table->unsignedBigInteger('raw_material_store_id')->nullable();
            $table->decimal('assigned_quantity');
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_preperation_id')->references('id')->on('product_order_preperations')->onDelete('cascade');
            $table->foreign('raw_material_store_id')->references('id')->on('raw_material_stores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_raw_materials');
    }
};
