<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sample_preparation_rnd', static function (Blueprint $table) {
            $table->boolean('is_yarn_ordered_weight_locked')->default(false)->after('yarnOrderedWeight');
            $table->boolean('is_yarn_leftover_weight_locked')->default(false)->after('yarnLeftoverWeight');
        });
    }

    public function down(): void
    {
        Schema::table('sample_preparation_rnd', static function (Blueprint $table) {
            $table->dropColumn(['is_yarn_ordered_weight_locked', 'is_yarn_leftover_weight_locked']);
        });
    }

};
