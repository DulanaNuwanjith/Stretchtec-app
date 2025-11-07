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
        Schema::create('product_order_preperations', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_inquiry_id');
            $table->string('prod_order_no');
            $table->string('customer_name');
            $table->string('reference_no');
            $table->string('item');
            $table->string('size');
            $table->string('color');
            $table->string('shade');
            $table->string('tkt');
            $table->decimal('qty');
            $table->string('uom');
            $table->string('supplier')->nullable();
            $table->string('pst_no')->nullable();
            $table->string('supplier_comment')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();

            $table->foreign('product_inquiry_id')->references('id')->on('product_inquiries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_order_preperations');
    }
};
