<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLatestVitalSigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('latest_vital_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->string('temperature')->nullable();
            $table->string('pulse_rate')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('oxygen_saturation')->nullable();
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
        Schema::dropIfExists('latest_vital_signs');
    }
}
