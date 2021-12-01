<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examination_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->index('examination_results_fk_institute_id');
            $table->unsignedInteger('user_id')->comment('trainer id')->index('examination_results_fk_user_id');;
            $table->unsignedInteger('youth_id')->index('examination_results_fk_institute_id');
            $table->unsignedInteger('examination_id')->index('examination_results_fk_examination_id');
            $table->unsignedInteger('batch_id')->index('examination_results_fk_batch_id');
            $table->unsignedInteger('training_center_id')->index('examination_results_fk_training_center_id');
            $table->unsignedInteger('achieved_marks');
            $table->tinyInteger('feedback')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('examination_results');
    }
}
