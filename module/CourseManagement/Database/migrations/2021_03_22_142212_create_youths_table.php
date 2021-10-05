<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('access_key', 50)->unique();
            $table->string('name_en', 191)->nullable();
            $table->string('name_bn', 191)->nullable();
            $table->string('mobile', 20)->index('youths_mobile');
            $table->string('email', 191)->index('youths_email')->unique();
            $table->unsignedTinyInteger('present_address_division_id');
            $table->unsignedTinyInteger('present_address_district_id');
            $table->unsignedSmallInteger('present_address_upazila_id');
            $table->string('present_address_house_address', 255);
            $table->unsignedTinyInteger('permanent_address_division_id');
            $table->unsignedTinyInteger('permanent_address_district_id');
            $table->unsignedSmallInteger('permanent_address_upazila_id');
            $table->string('permanent_address_house_address', 255);
            $table->unsignedTinyInteger('ethnic_group')->nullable()->default(2);

            $table->string('youth_registration_no', 30)->nullable();
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
        Schema::dropIfExists('youths');
    }
}
