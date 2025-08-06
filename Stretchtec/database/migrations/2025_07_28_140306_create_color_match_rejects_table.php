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
        Schema::create('color_match_rejects', function (Blueprint $table) {
            $table->id();

            // Foreign key field for orderNo
            $table->string('orderNo');
            $table->dateTime('sentDate')->nullable();
            $table->dateTime('receiveDate')->nullable();
            $table->dateTime('rejectDate')->nullable();
            $table->string('rejectReason')->nullable();

            // Define foreign key constraint
            $table->foreign('orderNo')
                ->references('orderNo')
                ->on('sample_inquiries')
                ->onDelete('cascade'); // You can change cascade behavior if needed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_match_rejects');
    }
};
