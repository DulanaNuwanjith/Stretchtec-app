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
        Schema::table('stores', function (Blueprint $table) {
            // If the column doesn't exist, add it
            if (!Schema::hasColumn('stores', 'mail_no')) {
                $table->unsignedBigInteger('mail_no')->nullable()->after('order_no');
            }

            // Add the foreign key constraint
            $table->foreign('mail_no')
                ->references('id')
                ->on('mail_bookings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Drop the foreign key first to avoid rollback issues
            $table->dropForeign(['mail_no']);
        });
    }
};
