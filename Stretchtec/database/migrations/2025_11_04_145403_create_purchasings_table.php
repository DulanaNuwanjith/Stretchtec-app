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
    Schema::create('purchasings', function (Blueprint $table) {
        $table->id();
        $table->string('order_no');
        $table->string('color');
        $table->string('shade');
        $table->string('pst_no')->nullable();
        $table->string('tkt')->nullable();
        $table->string('supplier_comment')->nullable();
        $table->string('type'); 
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasings');
    }
};
