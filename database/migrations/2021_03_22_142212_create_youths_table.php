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
            $table->string('name', 191)->nullable();
            $table->string('mobile', 20)->index('trainee_mobile');
            $table->string('email', 191)->index('trainee_email')->unique();
            $table->unsignedTinyInteger('loc_division_id');
            $table->unsignedTinyInteger('loc_district_id');
            $table->unsignedSmallInteger('loc_upazila_id');
            $table->dateTime('date_of_birth');
            $table->unsignedTinyInteger('gender');
            $table->unsignedTinyInteger('disable_status')->comment('1 => yes(disable) , 2 => no(not disable)');
            $table->unsignedTinyInteger('ethnic_group')->nullable()->default(2);
            $table->string('signature_pic')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('password')->nullable();
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
