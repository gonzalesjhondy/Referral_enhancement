<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObstetricAndGynecologicHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obstetric_and_gynecologic_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->string('menarche')->nullable();
            $table->boolean('menopause')->nullable();
            $table->string('menstrual_cycle')->nullable();
            $table->string('menstrual_cycle_duration')->nullable();
            $table->string('menstrual_cycle_padsperday')->nullable();
            $table->string('menstrual_cycle_dysmenorrhea')->nullable();
            $table->string('menstrual_cycle_medication')->nullable();
            $table->string('contraceptive_history')->nullable();
            $table->string('parity_g')->nullable();
            $table->string('parity_p')->nullable();
            $table->string('parity_ft')->nullable();
            $table->string('parity_pt')->nullable();
            $table->string('parity_a')->nullable();
            $table->string('parity_l')->nullable();
            $table->string('parity_lnmp')->nullable();
            $table->string('parity_edc')->nullable();
            $table->string('aog_lnmp')->nullable();
            $table->string('aog_eutz')->nullable();
            $table->string('prenatal_history')->nullable();
            $table->integer('pregnancy_order')->nullable();
            $table->string('pregnancy_year')->nullable();
            $table->string('pregnancy_gestation_completed')->nullable();
            $table->string('pregnancy_outcome')->nullable();
            $table->string('pregnancy_place_of_birth')->nullable();
            $table->string('pregnancy_sex')->nullable();
            $table->string('pregnancy_birth_weight')->nullable();
            $table->string('pregnancy_present_status')->nullable();
            $table->string('pregnancy_complication')->nullable();
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
        Schema::dropIfExists('obstetric_and_gynecologic_history');
    }
}
