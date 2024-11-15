<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBedTracker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bed_tracker', function (Blueprint $table) {
            $table->increments('id')->nullable()->before('emergency_room_covid');
            $table->integer('encoded_by')->nullable()->after('id');
            $table->integer('facility_id')->nullable()->after('encoded_by');
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
