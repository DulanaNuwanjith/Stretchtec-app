<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->string('yarnOrderedWeight')->nullable()->after('productionOutput'); // or after 'yarnOrderedQty'
            $table->string('yarnLeftoverWeight')->nullable()->after('yarnOrderedWeight');
        });
    }

    public function down()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->dropColumn(['yarnOrderedWeight', 'yarnLeftoverWeight']);
        });
    }
};
