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
            $table->string('name', 191)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('relation_with_youth', 191);
            $table->tinyInteger('gender')->nullable();
            $table->string('occupation', 191)->nullable();
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
