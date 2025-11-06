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
        Schema::create('raw_material_stores', static function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->string('shade');
            $table->string('pst_no')->nullable();
            $table->string('tkt');
            $table->string('supplier');
            $table->integer('available_quantity');
            $table->string('unit');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_stores');
    }
};
