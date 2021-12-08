<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('institute_id', 'courses_fk_institute_id')->references('id')->on('institutes')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('branch_id', 'courses_fk_branch_id')->references('id')->on('branches')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('training_center_id', 'courses_fk_training_center_id')->references('id')->on('training_centers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('application_form_type_id', 'courses_fk_application_form_type_id')->references('id')->on('application_form_types')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign('courses_fk_institute_id');
            $table->dropForeign('courses_fk_branch_id');
            $table->dropForeign('courses_fk_training_center_id');
            $table->dropForeign('courses_fk_application_form_type_id');
        });
    }
}
