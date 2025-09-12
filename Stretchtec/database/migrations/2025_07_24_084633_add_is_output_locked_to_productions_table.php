<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sample_preparation_production', static function (Blueprint $table) {
            $table->boolean('is_output_locked')->default(false);
            $table->boolean('is_damagedOutput_locked')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('productions', static function (Blueprint $table) {
            $table->dropColumn('is_output_locked');
            $table->dropColumn('is_damagedOutput_locked');
        });
    }

};
