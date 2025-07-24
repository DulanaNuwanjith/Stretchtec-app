<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sample_preparation_rnd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_inquiry_id')->constrained()->onDelete('cascade');
            $table->string('orderNo');
            $table->date('customerRequestDate')->nullable();
            $table->text('note')->nullable();

            // Future fields (optional placeholders)
            $table->date('developPlannedDate')->nullable();
            $table->boolean('is_dev_plan_locked')->default(false);
            $table->timestamp('colourMatchSentDate')->nullable();
            $table->timestamp('colourMatchReceiveDate')->nullable();
            $table->timestamp('yarnOrderedDate')->nullable();
            $table->string('yarnOrderedPONumber')->nullable();
            $table->string('shade')->nullable();
            $table->string('tkt')->nullable();
            $table->string('yarnSupplier')->nullable();
            $table->timestamp('yarnReceiveDate')->nullable();
            $table->date('productionDeadline')->nullable();
            $table->timestamp('sendOrderToProductionStatus')->nullable();
            $table->string('productionStatus')->nullable();
            $table->string('referenceNo')->nullable();
            $table->string('productionOutput')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_preparation_rnd');
    }
};
