<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescribedPrescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribed_prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescribed_activity_id')->nullable();
            $table->string('code', 255)->nullable();
            $table->text('generic_name')->nullable();
            $table->string('dosage', 255)->nullable();
            $table->string('formulation', 255)->nullable();
            $table->string('brandname', 255)->nullable();
            $table->string('frequency', 255)->nullable();
            $table->string('duration', 255)->nullable();
            $table->string('quantity', 255)->nullable();
            $table->integer('referred_from')->nullable();
            $table->integer('referred_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescribed_prescriptions');
    }
}
