<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplePreparationProductionTable extends Migration
{
    public function up()
    {
        Schema::create('sample_preparation_production', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_preparation_rnd_id')->constrained('sample_preparation_rnd')->onDelete('cascade');
            $table->string('order_no');
            $table->date('production_deadline')->nullable();
            $table->dateTime('order_received_at')->nullable();
            $table->dateTime('order_start_at')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->dateTime('order_complete_at')->nullable();
            $table->string('production_output')->nullable();
            $table->string('damaged_output')->nullable();
            $table->dateTime('dispatch_to_rnd_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sample_preparation_production');
    }
}
