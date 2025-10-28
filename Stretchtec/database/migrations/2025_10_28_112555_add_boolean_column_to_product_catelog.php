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
        Schema::table('product_catalogs', static function (Blueprint $table) {
            // Add the new boolean column after 'shade'
            $table->boolean('isShadeSelected')
                ->default(false)
                ->after('shade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_catalogs', static function (Blueprint $table) {
            // Drop the column if rolled back
            $table->dropColumn('isShadeSelected');
        });
    }
};
