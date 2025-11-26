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
        Schema::table('product_catalogs', function (Blueprint $table) {
            $table->string('option')->nullable()->after('shade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_catalogs', function (Blueprint $table) {
            $table->dropColumn('option');
        });
    }
};
