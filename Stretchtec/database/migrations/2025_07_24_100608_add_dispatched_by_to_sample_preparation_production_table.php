<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sample_preparation_production', function (Blueprint $table) {
            $table->string('dispatched_by')->nullable()->after('dispatch_to_rnd_at');
        });
    }

};
