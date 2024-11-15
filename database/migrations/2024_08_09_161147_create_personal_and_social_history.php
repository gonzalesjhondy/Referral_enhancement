<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalAndSocialHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_and_social_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->boolean('smoking')->nullable();
            $table->integer('smoking_sticks_per_day')->nullable();
            $table->string('smoking_quit_year')->nullable();
            $table->string('smoking_remarks')->nullable();
            $table->boolean('alcohol_drinking')->nullable();
            $table->string('alcohol_liquor_type')->nullable();
            $table->string('alcohol_drinking_quit_year')->nullable();
            $table->boolean('illicit_drugs')->nullable();
            $table->string('illicit_drugs_taken')->nullable();
            $table->string('illicit_drugs_quit_year')->nullable();
            $table->string('current_medications')->nullable();
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
        Schema::dropIfExists('personal_and_social_history');
    }
}
