<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacility1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility', function (Blueprint $table) {
            //COVID BEDS
            $table->string('emergency_room_covid_vacant')->nullable()->after('emergency_room_covid');
            $table->string('emergency_room_covid_occupied')->nullable()->after('emergency_room_covid_vacant');


            $table->string('icu_covid_vacant')->nullable()->after('icu_covid');
            $table->string('icu_covid_occupied')->nullable()->after('icu_covid_vacant');


            $table->string('beds_covid_vacant')->nullable()->after('beds_covid');
            $table->string('beds_covid_occupied')->nullable()->after('beds_covid_vacant');


            $table->string('isolation_covid_vacant')->nullable()->after('isolation_covid');
            $table->string('isolation_covid_occupied')->nullable()->after('isolation_covid_vacant');


            //NON COVIDS BEDS
            $table->string('emergency_room_non_vacant')->nullable()->after('emergency_room_non');
            $table->string('emergency_room_non_occupied')->nullable()->after('emergency_room_non_vacant');


            $table->string('icu_non_vacant')->nullable()->after('icu_non');
            $table->string('icu_non_occupied')->nullable()->after('icu_non_vacant');


            $table->string('beds_non_vacant')->nullable()->after('beds_non');
            $table->string('beds_non_occupied')->nullable()->after('beds_non_vacant');


            $table->string('isolation_non_vacant')->nullable()->after('isolation_non');
            $table->string('isolation_non_occupied')->nullable()->after('isolation_non_vacant');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
