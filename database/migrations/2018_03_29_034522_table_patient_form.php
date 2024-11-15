<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePatientForm extends Migration
{
    public function up()
    {
        if(Schema::hasTable('patient_form')){
            return true;
        }
        Schema::create('patient_form', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id',50)->unique();
            $table->string('code',50);
            $table->integer('referring_facility');
            $table->integer('referred_to');
            $table->dateTime('time_referred');
            $table->dateTime('time_transferred');
            $table->integer('patient_id');
            $table->text('case_summary');
            $table->text('reco_summary');
            $table->string('diagnosis');
            $table->string('reason');
            $table->integer('referring_md');
            $table->integer('referred_md');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_form');
    }
}
