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
        Schema::create('leftover_yarns', function (Blueprint $table) {
            $table->id();
            $table->string('shade')->nullable();                              // Shade
            $table->string('po_number')->nullable();                          // Yarn Ordered PO Number
            $table->date('yarn_received_date')->nullable();                   // Yarn Received Date
            $table->string('tkt')->nullable();                                // Tkt
            $table->string('yarn_supplier')->nullable();                      // Yarn Supplier
            $table->integer('available_stock')->default(0);             // Available Stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leftover_yarns');
    }
};
