<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->boolean('order_cancel')->default(0);
        });
    }

    public function down()
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            $table->dropColumn('order_cancel');
        });
    }

};
