<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('tracking')){
            return true;
        }
        Schema::table('tracking', function (Blueprint $table) {
            $table->integer('department_id')->after('referred_to');
        });

        Schema::table('activity', function (Blueprint $table) {
            $table->integer('department_id')->after('referred_to');
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
