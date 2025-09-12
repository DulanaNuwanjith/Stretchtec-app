<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operatorsand_supervisors', static function (Blueprint $table) {
            $table->id();
            $table->string('empID')->unique();
            $table->string('name');
            $table->string('phoneNo');
            $table->string('address')->nullable();
            $table->string('role'); // 'operator' or 'supervisor'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operatorsand_supervisors');
    }
};
