<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePregnantForm extends Migration
{
    public function up()
    {
        if(Schema::hasTable('pregnant_form')){
            return true;
        }
        Schema::create('pregnant_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id',50)->unique();
            $table->string('code',50);
            $table->integer('referring_facility');
            $table->integer('referred_by');
            $table->string('record_no');
            $table->dateTime('referred_date');
            $table->integer('referred_to');
            $table->dateTime('arrival_date');
            $table->string('health_worker');
            $table->integer('patient_woman_id');
            $table->string('woman_reason');
            $table->text('woman_major_findings');
            $table->string('woman_before_treatment');
            $table->dateTime('woman_before_given_time');
            $table->string('woman_during_transport');
            $table->dateTime('woman_transport_given_time');
            $table->text('woman_information_given');
            $table->integer('patient_baby_id');
            $table->string('baby_reason');
            $table->text('baby_major_findings');
            $table->dateTime('baby_last_feed');
            $table->string('baby_before_treatment');
            $table->dateTime('baby_before_given_time');
            $table->string('baby_during_transport');
            $table->dateTime('baby_transport_given_time');
            $table->text('baby_information_given');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pregnant_form');
    }
}
