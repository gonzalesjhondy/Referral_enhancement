<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPregnantForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pregnant_form', function (Blueprint $table) {
            $table->string('covid_number',255)->nullable()->after('department_id');
            $table->string('refer_clinical_status',50)->nullable()->after('covid_number');
            $table->string('refer_sur_category',50)->nullable()->after('refer_clinical_status');
            $table->string('dis_clinical_status',50)->nullable()->after('refer_sur_category');
            $table->string('dis_sur_category',50)->nullable()->after('dis_clinical_status');
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
