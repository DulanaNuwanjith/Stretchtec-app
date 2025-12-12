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
        Schema::table('product_order_preperations', function (Blueprint $table) {
            // First, modify the existing column to be nullable
            // Note: This requires doctrine/dbal package usually, but let's try assuming standard environment or raw statement if needed.
            // If strict mode is on, we might need to handle FKs carefully.
            $table->unsignedBigInteger('product_inquiry_id')->nullable()->change();

            // Add new column for MailBooking
            $table->unsignedBigInteger('mail_booking_id')->nullable()->after('product_inquiry_id');
            
            // Add Foreign Key
            $table->foreign('mail_booking_id')->references('id')->on('mail_bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_order_preperations', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['mail_booking_id']);
            $table->dropColumn('mail_booking_id');

            // Revert product_inquiry_id to not null (caution: this might fail if there are nulls)
            // We usually don't revert 'nullable' to 'not null' without data cleanup, 
            // but for 'down' we assume we want to go back to original state.
            $table->unsignedBigInteger('product_inquiry_id')->nullable(false)->change();
        });
    }
};
