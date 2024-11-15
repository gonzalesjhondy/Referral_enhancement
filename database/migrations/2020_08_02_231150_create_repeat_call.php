<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepeatCall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('repeat_call')){
            return true;
        }
        Schema::create('repeat_call', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('encoded_by')->nullable();
            $table->string('call_classification')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('sex')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('municipality_id')->nullable();
            $table->integer('barangay_id')->nullable();
            $table->string('sitio')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('relationship')->nullable();
            $table->string('reason_calling')->nullable();
            $table->string('reason_notes')->nullable();
            $table->string('reason_patient_data')->nullable();
            $table->string('reason_chief_complains')->nullable();
            $table->string('reason_action_taken')->nullable();
            $table->string('transaction_complete')->nullable();
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
        //
    }
}
