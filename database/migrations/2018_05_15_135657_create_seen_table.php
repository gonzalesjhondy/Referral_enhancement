<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seen')){
            return true;
        }
        Schema::create('seen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tracking_id');
            $table->integer('facility_id');
            $table->integer('user_md');
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
        Schema::dropIfExists('seen');
    }
}
