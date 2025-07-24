<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sample_preparation_production', function (Blueprint $table) {
            $table->boolean('is_output_locked')->default(false);
        });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('is_output_locked');
        });
    }

};
