<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sample_inquiries', static function (Blueprint $table) {
            $table->string('ItemDiscription')->nullable(); // match your model and controller
        });
    }

    public function down(): void
    {
        Schema::table('sample_inquiries', static function (Blueprint $table) {
            $table->dropColumn('ItemDiscription');
        });
    }
};
