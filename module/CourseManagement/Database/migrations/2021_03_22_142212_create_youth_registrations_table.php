<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youth_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('youth_registration_no', 30)->nullable();
            $table->unsignedInteger('youth_id')->index('youth_registrations_fk_youth_id');
            $table->unsignedInteger('institute_id')->nullable()->index('youth_registrations_fk_institute_id');
            $table->unsignedInteger('branch_id')->nullable()->index('youth_registrations_fk_branch_id');
            $table->unsignedInteger('training_center_id')->nullable()->index('youth_registrations_fk_training_center_id');
            $table->unsignedInteger('programme_id')->nullable()->index('youth_registrations_fk_programme_id');
            $table->unsignedInteger('publish_course_id')->nullable()->index('youth_registrations_fk_publish_course_id');
            $table->tinyInteger('recommended_by_organization')->nullable();
            $table->string('recommended_org_name', 191)->nullable();
            $table->tinyInteger('current_employment_status')->nullable();
            $table->tinyInteger('year_of_experience')->nullable();
            $table->integer('personal_monthly_income')->nullable();
            $table->tinyInteger('have_family_own_house')->nullable();
            $table->tinyInteger('have_family_own_land')->nullable();
            $table->tinyInteger('number_of_siblings')->nullable();
            $table->string('student_signature_pic')->nullable();
            $table->string('student_pic')->nullable();
            $table->timestamps();
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('youth_registrations');
    }
}
