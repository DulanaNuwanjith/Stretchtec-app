<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->boolean('is_yarn_ordered_weight_locked')->default(false)->after('yarnOrderedWeight');
            $table->boolean('is_yarn_leftover_weight_locked')->default(false)->after('yarnLeftoverWeight');
        });
    }

    public function down()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->dropColumn(['is_yarn_ordered_weight_locked', 'is_yarn_leftover_weight_locked']);
        });
    }

};
