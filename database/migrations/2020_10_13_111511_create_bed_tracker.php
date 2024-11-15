<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedTracker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_tracker', function (Blueprint $table) {
            //COVID BEDS
            $table->string('emergency_room_covid')->nullable();
            $table->string('icu_covid')->nullable();
            $table->string('beds_covid')->nullable();
            $table->string('isolation_covid')->nullable();
            $table->string('mechanical_used_covid')->nullable();
            $table->string('mechanical_vacant_covid')->nullable();

            //NON COVIDS BEDS
            $table->string('emergency_room_non')->nullable();
            $table->string('icu_non')->nullable();
            $table->string('beds_non')->nullable();
            $table->string('isolation_non')->nullable();
            $table->string('mechanical_used_non')->nullable();
            $table->string('mechanical_vacant_non')->nullable();

            //NUMBER OF WAIT LIST
            $table->string('emergency_room_covid_wait')->nullable();
            $table->string('icu_covid_wait')->nullable();
            $table->string('emergency_room_non_wait')->nullable();
            $table->string('icu_non_wait')->nullable();

            $table->string('remarks')->nullable();
            $table->string('status')->nullabe();

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
        Schema::dropIfExists('bed_tracker');
    }
}
