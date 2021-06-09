<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->foreign('application_form_type_id', 'batches_fk_application_form_type_id')->references('id')->on('application_form_types')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('branch_id', 'batches_fk_branch_id')->references('id')->on('branches')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('course_id', 'batches_fk_course_id')->references('id')->on('courses')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('institute_id', 'batches_fk_institute_id')->references('id')->on('institutes')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('programme_id', 'batches_fk_programme_id')->references('id')->on('programmes')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('training_center_id', 'batches_fk_training_center_id')->references('id')->on('training_centers')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropForeign('batches_fk_application_form_type_id');
            $table->dropForeign('batches_fk_branch_id');
            $table->dropForeign('batches_fk_course_id');
            $table->dropForeign('batches_fk_institute_id');
            $table->dropForeign('batches_fk_programme_id');
            $table->dropForeign('batches_fk_training_center_id');
        });
    }
}
