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
            $table->string('reference_note');
            $table->string('size');
            $table->string('color');
            $table->string('rubber_type');
            $table->string('weft_yarn');
            $table->string('warp_yarn');
            $table->string('knitting_machine');
            $table->string('wheel_up');
            $table->string('wheel_down');
            $table->string('needles');
            $table->string('stretch');
            $table->string('weight');
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
