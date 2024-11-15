<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->integer('appointment')->nullable()->after('remarks');
            $table->text('generic_name')->nullable()->after('appointment');
            $table->string('dosage', 255)->nullable()->after('generic_name');
            $table->string('formulation', 255)->nullable()->after('dosage');
            $table->string('brandname', 255)->nullable()->after('formulation');
            $table->string('frequency', 255)->nullable()->after('brandname');
            $table->string('duration', 255)->nullable()->after('frequency');
            $table->string('quantity', 255)->nullable()->after('duration');
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
