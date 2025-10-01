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
        Schema::table('sample_inquiries', static function (Blueprint $table) {
            $table->string('po_identification')->nullable()->after('inquiryReceiveDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sample_inquiries', static function (Blueprint $table) {
            $table->dropColumn('po_identification');
        });
    }
};
