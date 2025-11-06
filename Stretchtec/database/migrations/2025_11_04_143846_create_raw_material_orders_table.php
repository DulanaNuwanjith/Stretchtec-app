<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raw_material_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->string('color');
            $table->string('shade');
            $table->string('pst_no')->nullable();
            $table->string('tkt')->nullable();
            $table->string('supplier_comment')->nullable();
            $table->integer('qty');
            $table->enum('kg_or_cone', ['kg', 'cone'])->default('kg');
            $table->decimal('price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_orders');
    }
};
