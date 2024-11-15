<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecoSeen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reco_seen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reco_id')->nullable();
            $table->integer('seen_userid')->nullable();
            $table->integer('seen_facility_id')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('reco_seen');
    }
}
