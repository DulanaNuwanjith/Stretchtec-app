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
        Schema::create('mail_booking_approvals', static function (Blueprint $table) {
            $table->id();

            // Foreign key reference to mail_bookings table
            $table->unsignedBigInteger('mail_booking_id');

            $table->text('remarks')->nullable();

            $table->timestamps();

            // Define foreign key constraint for relational integrity
            $table->foreign('mail_booking_id')
                ->references('id')
                ->on('mail_bookings')
                ->onDelete('cascade'); // Ensures cleanup if the mail booking is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_booking_approvals');
    }
};
