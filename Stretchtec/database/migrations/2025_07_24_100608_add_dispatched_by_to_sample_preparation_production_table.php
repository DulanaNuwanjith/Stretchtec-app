<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sample_preparation_production', static function (Blueprint $table) {
            $table->string('dispatched_by')->nullable()->after('dispatch_to_rnd_at');
        });
    }

};
