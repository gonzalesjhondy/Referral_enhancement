<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableFacility extends Migration
{
    public function up()
    {
        if(Schema::hasTable('facility')){
            return true;
        }
        Schema::create('facility', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->integer('brgy');
            $table->integer('muncity');
            $table->integer('province');
            $table->string('contact');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facility');
    }
}
