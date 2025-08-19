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
            $table->string('pst_no')->nullable()->after('yarnReceiveDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sample_preparation_rnd', function (Blueprint $table) {
            //
        });
    }
};
