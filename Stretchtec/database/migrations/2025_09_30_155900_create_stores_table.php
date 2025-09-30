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
        Schema::create('stores', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_no')->nullable();
            $table->string('prod_order_no')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('shade')->nullable();
            $table->integer('qty_available');
            $table->integer('qty_allocated')->nullable();
            $table->longText('reason_for_reject')->nullable();
            $table->integer('qty_for_production')->nullable();
            $table->string('assigned_by');
            $table->boolean('is_qty_assigned')->default(false);
            $table->timestamps();

            //Foreign Key for po_number and reference_number
            $table->foreign('order_no')->references('id')->on('product_inquiries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
