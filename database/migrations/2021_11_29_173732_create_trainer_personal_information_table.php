<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainerPersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_personal_information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('trainer_personal_information_fk_user_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->unsignedInteger('institute_id')->nullable();
            $table->string('profile_pic')->nullable();
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('trainer_personal_information');
    }
}
