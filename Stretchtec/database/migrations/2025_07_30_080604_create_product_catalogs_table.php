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
        Schema::create('product_catalogs', function (Blueprint $table) {
            $table->id();

            // Foreign keys (assuming each catalog belongs to one R&D record)
            $table->unsignedBigInteger('sample_preparation_rnd_id')->nullable();
            $table->unsignedBigInteger('sample_inquiry_id')->nullable();

            // Fields from R&D and Inquiry
            $table->string('order_no'); // from R&D
            $table->string('reference_no'); // from R&D
            $table->date('reference_added_date'); // new field: current date
            $table->string('coordinator_name'); // from Inquiry
            $table->string('item'); // from Inquiry
            $table->string('size')->nullable(); // from Inquiry
            $table->string('colour')->nullable(); // from Inquiry or R&D
            $table->string('shade')->nullable(); // from R&D
            $table->string('tkt')->nullable(); // from R&D

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('sample_preparation_rnd_id')->references('id')->on('sample_preparation_rnd')->onDelete('cascade');
            $table->foreign('sample_inquiry_id')->references('id')->on('sample_inquiries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_catalogs');
    }
};
