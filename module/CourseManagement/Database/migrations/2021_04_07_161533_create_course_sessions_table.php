<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->index('course_sessions_fk_course_id');
            $table->unsignedInteger('publish_course_id')->index('course_sessions_fk_publish_course_id');
            $table->unsignedTinyInteger('number_of_batches');
            $table->dateTime('application_start_date');
            $table->dateTime('application_end_date');
            $table->dateTime('course_start_date');
            $table->unsignedSmallInteger('max_seat_available')->default(0);
            $table->timestamps();
            $table->foreign('course_id', 'course_sessions_fk_course_id')->references('id')->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('publish_course_id', 'course_sessions_fk_publish_course_id')->references('id')->on('publish_courses')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_sessions');
    }
}
