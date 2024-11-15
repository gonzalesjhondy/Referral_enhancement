<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItCall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_call', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('encoded_by')->nullable();
            $table->integer('facility_id')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();

            $table->string('type_call')->nullable();
            $table->string('call_classification')->nullable();
            $table->text('reason_calling')->nullable();
            $table->text('reason_others')->nullable();
            $table->text('notes')->nullable();
            $table->text('action')->nullable();

            $table->text('transaction_complete')->nullable();
            $table->string('transaction_incomplete')->nullable();

            $table->dateTime('time_started')->nullable();
            $table->dateTime('time_ended')->nullable();
            $table->string('time_duration')->nullable();
            $table->string('status')->nullabe();
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
        Schema::dropIfExists('it_call');
    }
}
