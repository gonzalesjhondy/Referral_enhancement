<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToFacAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'facility_assignment';
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'user_id')) {
                $table->integer('user_id')->after('username');
            }
            if (!Schema::hasColumn($tableName, 'facility_id')) {
                $table->integer('facility_id')->after('user_id');
            }
            if (!Schema::hasColumn($tableName, 'department_id')) {
                $table->integer('department_id')->after('facility_code');
            }
            if (!Schema::hasColumn($tableName, 'status')) {
                $table->string('status')->after('email');
            }
            if (!Schema::hasColumn($tableName, 'last_login')) {
                $table->dateTime('last_login')->after('status');
            }
            if (!Schema::hasColumn($tableName, 'login_status')) {
                $table->dateTime('login_status')->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fac_assignment', function (Blueprint $table) {
            //
        });
    }
}
