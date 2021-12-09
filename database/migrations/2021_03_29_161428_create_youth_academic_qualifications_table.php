<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthAcademicQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youth_academic_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('youth_id');
            $table->string('examination', 30);
            $table->string('examination_name', 30);
            $table->unsignedTinyInteger('board')->nullable();
            $table->string('institute', 191)->nullable();
            $table->string('roll_no',20)->nullable();
            $table->string('reg_no',20)->nullable();
            $table->unsignedFloat('grade', 3,2)->nullable();
            $table->unsignedTinyInteger('result');
            $table->unsignedTinyInteger('group')->nullable();
            $table->string('passing_year', 4);
            $table->string('subject', 30)->nullable();
            $table->unsignedTinyInteger('course_duration')->nullable();
            $table->timestamps();
            $table->foreign('youth_id', 'youth_academic_qualifications_fk_youth_id')->references('id')->on('youths')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('youth_academic_qualifications');
    }
}
