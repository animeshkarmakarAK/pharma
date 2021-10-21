<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en', 191)->nullable();
            $table->string('title_bn', 191)->nullable();
            $table->string('code', 191);
            $table->unsignedInteger('institute_id')->index('batches_fk_institute_id');
            $table->unsignedInteger('branch_id')->nullable()->index('batches_fk_branch_id');
            $table->unsignedInteger('training_center_id')->nullable()->index('batches_fk_training_center_id');
            $table->unsignedInteger('course_id')->index('batches_fk_course_id');
            $table->unsignedInteger('publish_course_id')->nullable()->index('batches_fk_publish_course_id');
            $table->unsignedInteger('programme_id')->nullable()->index('batches_fk_programme_id');
            $table->unsignedInteger('application_form_type_id')->nullable()->index('batches_fk_application_form_type_id');
            $table->integer('max_student_enrollment')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->unsignedTinyInteger('batch_status')->nullable()->comment(['1=>On Going Batch, 2=>Complete Batch']);
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
        Schema::dropIfExists('batches');
    }
}
