<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlasgowComaScale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glasgow_coma_scale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->string('pupil_size_chart')->nullable();
            $table->string('motor_response')->nullable();
            $table->string('verbal_response')->nullable();
            $table->string('eye_response')->nullable();
            $table->string('gsc_score')->nullable();
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
        Schema::dropIfExists('glasgow_coma_scale');
    }
}
