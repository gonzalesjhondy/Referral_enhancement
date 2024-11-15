<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->date('appointed_date')->nullable();
            $table->time('appointed_time')->nullable();
            $table->time('appointedTime_to')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('facility_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('opdCategory',255)->nullable();
            $table->integer('appointed_by')->nullable();
            $table->string('code',255)->nullable();
            $table->string('status',255)->nullable();
            $table->integer('slot')->nullable();
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
        Schema::dropIfExists('appointment_schedule');
    }
}
