<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('bed')){
            return true;
        }
        Schema::create('bed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_id');
            $table->integer('encoded_by');
            $table->string('name');
            $table->string('temporary');
            $table->integer('allowable_no');
            $table->integer('actual_no');
            $table->string('status');
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
        //
    }
}
