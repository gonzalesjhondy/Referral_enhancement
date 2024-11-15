<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('users')){
            return true;
        }
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique;
            $table->string('password');
            $table->string('level');
            $table->integer('facility_id');
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('title');
            $table->string('contact');
            $table->string('email');
            $table->integer('muncity');
            $table->integer('province');
            $table->string('accreditation_no');
            $table->string('accreditation_validity');
            $table->string('license_no');
            $table->string('prefix');
            $table->string('picture');
            $table->string('designation');
            $table->string('status');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
