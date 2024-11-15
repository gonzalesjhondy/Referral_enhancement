<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableTracking extends Migration
{
    public function up()
    {
        if(Schema::hasTable('tracking')){
            return true;
        }
        Schema::create('tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',50)->unique();
            $table->integer('patient_id');
            $table->dateTime('date_referred');
            $table->dateTime('date_arrived');
            $table->dateTime('date_seen');
            $table->integer('referred_from');
            $table->integer('referred_to');
            $table->text('remarks');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracking');
    }
}
