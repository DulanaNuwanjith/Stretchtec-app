<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sample_preparation_rnd', static function (Blueprint $table) {
            $table->string('alreadyDeveloped')->nullable()->after('colourMatchReceiveDate');
        });
    }

    public function down(): void
    {
        Schema::table('sample_preparation_rnd', static function (Blueprint $table) {
            $table->dropColumn('alreadyDeveloped');
        });
    }

};
