<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->nullable();
            $table->integer('requested_by')->nullable();
            $table->string('laboratory_code', 255)->nullable();
            $table->string('status', 255)->nullable();
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
        Schema::dropIfExists('lab_request');
    }
}
