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
        Schema::create('assigned_raw_material_exports', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_preperation_id');
            $table->unsignedBigInteger('export_raw_material_id');
            $table->decimal('assigned_quantity');
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_preperation_id')->references('id')->on('product_order_preperations')->onDelete('cascade');
            $table->foreign('export_raw_material_id')->references('id')->on('export_raw_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_raw_material_exports');
    }
};
