<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sample_preparation_rnd', static function (Blueprint $table) {
            $table->string('yarnOrderedWeight')->nullable()->after('productionOutput'); // or after 'yarnOrderedQty'
            $table->string('yarnLeftoverWeight')->nullable()->after('yarnOrderedWeight');
        });
    }

    public function down(): void
    {
        Schema::table('sample_preparation_rnd', static function (Blueprint $table) {
            $table->dropColumn(['yarnOrderedWeight', 'yarnLeftoverWeight']);
        });
    }
};
