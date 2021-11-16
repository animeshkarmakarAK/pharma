<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('informant_name')->nullable();
            $table->string('informant_email')->nullable();
            $table->integer('informant_mobile')->nullable();
            $table->date('informant_date')->nullable();
            $table->string('respondent_name')->nullable();
            $table->string('respondent_designation')->nullable();
            $table->string('respondent_others_detail')->nullable();
            $table->string('industry_sector')->nullable();
            $table->string('industry_started')->nullable();
            $table->string('industry_association')->nullable();
            $table->string('industry_type')->nullable();
            $table->integer('total_employee_one')->nullable();
            $table->integer('full_time_employee_one')->nullable();
            $table->integer('half_time_employee_one')->nullable();
            $table->integer('female_number_one')->nullable();
            $table->integer('male_number_one')->nullable();
            $table->string('others_number_one')->nullable();
            $table->integer('others_total_number')->nullable();
            $table->string('disabled_person')->nullable();
            $table->integer('disabled_person_number')->nullable();
            $table->string('unhelped_group')->nullable();
            $table->integer('unhelped_group_number')->nullable();
            $table->integer('senior_level_one')->nullable();
            $table->integer('middle_level_one')->nullable();
            $table->integer('junior_level_one')->nullable();
            $table->string('outside_employee')->nullable();
            $table->integer('other_country_employee_number')->nullable();
            $table->integer('senior_level_two')->nullable();
            $table->integer('middle_level_two')->nullable();
            $table->integer('junior_level_two')->nullable();
            $table->string('employee_problem')->nullable();
            $table->string('employee_problem_detail')->nullable();
            $table->string('employee_recruitment')->nullable();
            $table->string('institute_facilities')->nullable();
            $table->string('recruitment_media')->nullable();
            $table->string('decision_problem_1')->nullable();
            $table->string('decision_problem_2')->nullable();
            $table->string('decision_problem_3')->nullable();
            $table->string('decision_problem_4')->nullable();
            $table->string('decision_problem_5')->nullable();
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
        Schema::dropIfExists('organization_informations');
    }
}
