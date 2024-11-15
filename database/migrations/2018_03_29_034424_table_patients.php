<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePatients extends Migration
{
    public function up()
    {
        if(Schema::hasTable('patients')){
            return true;
        }
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id',50)->unique();
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->date('dob');
            $table->string('sex');
            $table->string('civil_status');
            $table->string('phic_id');
            $table->string('phic_status');
            $table->integer('brgy');
            $table->integer('muncity');
            $table->integer('province');
            $table->integer('tsekap_patient');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
