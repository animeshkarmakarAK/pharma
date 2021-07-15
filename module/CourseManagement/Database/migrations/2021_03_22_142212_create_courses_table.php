<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en', 191);
            $table->string('title_bn', 191);
            $table->unsignedDouble('course_fee', 11, 2)->default(0);
            $table->string('duration', 30)->nullable();
            $table->text('description')->nullable();
            $table->text('target_group')->nullable();
            $table->text('objects')->nullable();
            $table->text('contents')->nullable();
            $table->text('training_methodology')->nullable();
            $table->text('evaluation_system')->nullable();
            $table->text('prerequisite')->nullable();
            $table->text('eligibility')->nullable();
            $table->string('cover_image', 191)->nullable();
            $table->string('code', 191);
            $table->unsignedInteger('institute_id')->index('courses_fk_institute_id');
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
        Schema::dropIfExists('courses');
    }
}
