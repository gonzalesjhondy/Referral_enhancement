<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonitoringRemarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_not_accepted', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',255)->nullable();
            $table->integer('remark_by')->nullable();
            $table->integer('activity_id')->nullable();
            $table->integer('referring_facility')->nullable();
            $table->integer('referred_to')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('monitoring_not_accepted');
    }
}
