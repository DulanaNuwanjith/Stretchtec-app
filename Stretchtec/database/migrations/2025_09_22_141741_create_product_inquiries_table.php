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
        Schema::create('product_inquiries', static function (Blueprint $table) {
            $table->id();
            $table->string('prod_order_no');
            $table->dateTime('po_received_date');
            $table->string('order_type');
            $table->string('customer_name');
            $table->string('customer_coordinator');
            $table->string('merchandiser_name');
            $table->string('po_number');
            $table->date('production_deadline')->nullable();
            $table->string('deadline_reason')->nullable();
            $table->string('size');
            $table->string('item');
            $table->string('color');
            $table->string('reference_no');
            $table->string('shade');
            $table->string('tkt');
            $table->decimal('qty');
            $table->string('uom');
            $table->string('supplier')->nullable();
            $table->string('pst_no')->nullable();
            $table->string('supplier_comment')->nullable();
            $table->string('item_description')->nullable();
            $table->decimal('unitPrice');
            $table->decimal('price');
            $table->date('customer_req_date')->nullable();
            $table->date('our_prod_date')->nullable();
            $table->decimal('stock_qty')->nullable();
            $table->decimal('to_make_qty')->nullable();
            $table->decimal('delivered_qty')->nullable();
            $table->decimal('in_production_qty')->nullable();
            $table->decimal('balance_qty')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->boolean('isSentToStock')->nullable()->default(false);
            $table->timestamp('sent_to_stock_at')->nullable();
            $table->boolean('canSendToProduction')->default(false);
            $table->boolean('isSentToProduction')->default(false);
            $table->dateTime('sent_to_production_at')->nullable();
            $table->string('status')->default('Pending');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inquiries');
    }
};
