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
        Schema::create('sample_stocks', static function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 100);
            $table->string('shade', 100);
            $table->integer('available_stock')->default(0);
            $table->text('special_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_stocks');
    }
};
