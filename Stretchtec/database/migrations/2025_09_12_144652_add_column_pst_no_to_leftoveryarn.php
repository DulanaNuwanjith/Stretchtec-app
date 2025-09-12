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
        Schema::table('leftover_yarns', static function (Blueprint $table) {
            $table->string('pst_no')->nullable()->after('shade'); // add pst_no after shade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leftover_yarns', static function (Blueprint $table) {
            $table->dropColumn('pst_no');
        });
    }
};
