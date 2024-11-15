<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelemedAssignDoctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telemed_assign_doctor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_by')->nullable();
            $table->integer('appointment_id')->unsigned()->nullable();
            $table->integer('doctor_id')->nullable();
            $table->string('status', 255)->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('telemed_assign_doctor');
    }
}
