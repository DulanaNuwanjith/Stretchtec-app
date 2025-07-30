<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('product_catalogs', function (Blueprint $table) {
            $table->boolean('is_approved_by_locked')->default(false);
            $table->boolean('is_approval_card_locked')->default(false);
        });
    }

    public function down()
    {
        Schema::table('product_catalogs', function (Blueprint $table) {
            $table->dropColumn('is_approved_by_locked');
            $table->dropColumn('is_approval_card_locked');
        });
    }

};
