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
        Schema::create('shade_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_preparation_rnd_id')
                ->constrained('sample_preparation_rnd') // your RnD table
                ->onDelete('cascade'); // optional: delete shades if RnD deleted
            $table->string('shade');
            $table->string('status')->default('Pending'); // default status
            $table->DateTime('yarn_receive_date')->nullable();
            $table->string('pst_no')->nullable(); // PST number
            $table->integer('production_output')->nullable(); // production output
            $table->integer('damaged_output')->nullable(); // damaged output
            $table->string('dispatched_by')->nullable(); // dispatched by
            $table->dateTime('delivered_date')->nullable(); // delivered date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shade_orders');
    }
};
