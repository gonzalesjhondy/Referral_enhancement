<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateTransferredTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        if(Schema::hasTable('tracking')){
//            return true;
//        }
        Schema::table('tracking', function (Blueprint $table) {
            $table->dateTime('date_transferred')->after('date_referred');
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
