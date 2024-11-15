<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaccineAccomplish extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_accomplish', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('encoded_by')->nullable();
            $table->integer('vaccine_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('muncity_id')->nullable();
            $table->integer('facility_id')->nullable();
            $table->dateTime('daily_accomplishment')->nullable();
            $table->string('typeof_vaccine','100' )->nullable();
            $table->string('priority','100' )->nullable();
            $table->dateTime('date_first')->nullable();
            $table->dateTime('date_second')->nullable();
            $table->string('vaccinated_first')->nullable();
            $table->string('vaccinated_second')->nullable();
            $table->string('mild_first')->nullable();
            $table->string('mild_second')->nullable();
            $table->string('serious_first')->nullable();
            $table->string('serious_second')->nullable();
            $table->string('refused_first')->nullable();
            $table->string('refused_second')->nullable();
            $table->string('deferred_first')->nullable();
            $table->string('deferred_second')->nullable();
            $table->string('wastage_first')->nullable();
            $table->string('wastage_second')->nullable();
            $table->string('no_eli_pop')->nullable();
            $table->string('vaccine_allocated_first')->nullable();
            $table->string('vaccine_allocated_second')->nullable();

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
        Schema::dropIfExists('vaccine_accomplish');
    }
}
