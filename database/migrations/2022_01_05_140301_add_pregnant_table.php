<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPregnantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pregnant_form', function (Blueprint $table) {
            $table->string('notes_diagnoses')->nullable()->after('woman_information_given');
            $table->string('other_diagnoses')->nullable()->after('notes_diagnoses');
            $table->integer('reason_referral')->nullable()->after('other_diagnoses');
            $table->string('other_reason_referral')->nullable()->after('reason_referral');
            $table->string('file_path')->nullable()->after('other_reason_referral');
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
