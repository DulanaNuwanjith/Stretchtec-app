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
        Schema::create('technical_cards', static function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->string('type');
            $table->string('size');
            $table->string('color');
            $table->string('rubber_type')->nullable();
            $table->string('yarn_count')->nullable();
            $table->string('spindles')->nullable();
            $table->string('weft_yarn')->nullable();
            $table->string('warp_yarn')->nullable();
            $table->string('reed')->nullable();
            $table->string('machine');
            $table->string('wheel_up')->nullable();
            $table->string('wheel_down')->nullable();
            $table->string('needles')->nullable();
            $table->string('stretchability')->nullable();
            $table->string('weight_per_yard');
            $table->string('url')->nullable();
            $table->string('special_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical_cards');
    }
};
