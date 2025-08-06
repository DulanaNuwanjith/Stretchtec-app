<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sample_inquiries', function (Blueprint $table) {
            $table->string('ItemDiscription')->nullable(); // match your model and controller
        });
    }

    public function down()
    {
        Schema::table('sample_inquiries', function (Blueprint $table) {
            $table->dropColumn('ItemDiscription');
        });
    }
};
