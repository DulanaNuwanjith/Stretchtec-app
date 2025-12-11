<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_order_preperations', function (Blueprint $table) {
            $table->date('requested_date')->nullable()->after('reference_no');
        });
    }

    public function down()
    {
        Schema::table('product_order_preperations', function (Blueprint $table) {
            $table->dropColumn('requested_date');
        });
    }
};
