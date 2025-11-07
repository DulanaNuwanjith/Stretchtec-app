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
        Schema::create('purchase_departments', static function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->date('po_date');
            $table->string('shade');
            $table->string('color');
            $table->string('tkt');
            $table->string('pst_no')->nullable();
            $table->string('supplier_comment')->nullable();
            $table->string('uom');
            $table->decimal('quantity');
            $table->decimal('rate');
            $table->decimal('amount');
            $table->decimal('total_amount');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_departments');
    }
};
