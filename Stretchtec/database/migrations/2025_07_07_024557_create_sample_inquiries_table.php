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
        Schema::create('sample_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('orderFile')->nullable();
            $table->string('orderNo')->unique();
            $table->date('inquiryReceiveDate');
            $table->string('customerName');
            $table->string('merchandiseName');
            $table->string('item');
            $table->string('size');
            $table->string('color');
            $table->string('sampleQty');
            $table->longText('customerSpecialComment')->nullable();
            $table->date('customerRequestDate')->nullable();
            $table->boolean('alreadyDeveloped')->default(false);
            $table->string('sentToSampleDevelopmentDate')->nullable();
            $table->date('developPlannedDate')->nullable();
            $table->string('productionStatus')->default('Pending');
            $table->string('referenceNo')->nullable();
            $table->dateTime('customerDeliveryDate')->nullable();
            $table->string('customerDecision')->default('pending');
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_inquiries');
    }
};
