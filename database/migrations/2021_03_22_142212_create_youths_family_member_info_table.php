<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthsFamilyMemberInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youths_family_member_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('youth_id')->index('youth_family_members_info_youth_id');
            $table->string('member_name', 191)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('educational_qualification', 191)->nullable();
            $table->string('relation_with_youth', 191);
            $table->tinyInteger('is_guardian')->nullable();
            $table->integer('personal_monthly_income')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->string('main_occupation', 191)->nullable();
            $table->string('other_occupations', 191)->nullable();
            $table->string('physical_disabilities', 191)->nullable();
            $table->tinyInteger('disable_status')->nullable();
            $table->tinyInteger('freedom_fighter_status')->nullable();
            $table->string('nid', 30)->nullable()->index('youths_family_member_info_nid');
            $table->string('birth_certificate_no', 30)->nullable()->index('youths_family_member_info_birth_certificate_no');
            $table->string('passport_number', 30)->nullable()->index('youths_family_member_info_passport_number');
            $table->tinyInteger('religion')->nullable();
            $table->string('nationality', 30)->nullable();
            $table->date('date_of_birth')->nullable();
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
        Schema::dropIfExists('youths_family_member_info');
    }
}
