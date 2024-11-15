<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPatientformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_form', function (Blueprint $table) {
            $table->integer('reason_referral')->nullable()->after('referred_md');
            $table->string('other_reason_referral')->nullable()->after('reason_referral');
            $table->string('file_path')->nullable()->after('other_reason_referral');
            $table->string('other_diagnoses')->nullable()->after('file_path');
            $table->string('notes_diagnoses')->nullable()->after('other_diagnoses');
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
