<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExaminationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('batch_id')->index('examinations_fk_batch_id');
            $table->unsignedInteger('training_center_id')->index('examinations_fk_training_center_id');
            $table->unsignedInteger('exam_type_id')->index('examinations_fk_exam_type_id');
            $table->unsignedInteger('pass_mark');
            $table->unsignedInteger('total_mark');
            $table->mediumText('exam_details')->nullable();
            $table->tinyInteger('row_status')->default(1);
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
        Schema::dropIfExists('examinations');
    }
}
