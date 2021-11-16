<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publish_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->index('publish_courses_fk_institute_id');
            $table->unsignedInteger('branch_id')->nullable()->index('publish_courses_fk_branch_id');
            $table->text('training_center_id')->nullable();//->index('publish_courses_fk_training_center_id');
            $table->unsignedInteger('programme_id')->nullable()->index('publish_courses_fk_programme_id');
            $table->unsignedInteger('application_form_type_id')->index('publish_courses_fk_application_form_type_id');
            $table->unsignedInteger('course_id')->index('publish_courses_fk_course_id');
            $table->string('title_en', 191)->nullable();
            $table->string('title_bn', 191)->nullable();
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable();
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
        Schema::dropIfExists('publish_courses');
    }
}
