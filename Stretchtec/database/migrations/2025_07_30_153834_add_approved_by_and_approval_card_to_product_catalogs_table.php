<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_catalogs', function (Blueprint $table) {
            $table->string('approved_by')->nullable()->after('tkt');
            $table->string('approval_card')->nullable()->after('approved_by');
        });
    }

    public function down(): void
    {
        Schema::table('product_catalogs', function (Blueprint $table) {
            $table->dropColumn(['approved_by', 'approval_card']);
        });
    }
};
