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
        Schema::create('knitted_section_orders', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_preperation_id');
            $table->unsignedBigInteger('product_inquiry_id');
            $table->string('prod_order_no');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('order_preperation_id')->references('id')->on('product_order_preperations')->onDelete('cascade');
            $table->foreign('product_inquiry_id')->references('id')->on('product_inquiries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knitted_section_orders');
    }
};
