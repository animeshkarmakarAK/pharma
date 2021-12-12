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
            $table->unsignedInteger('course_id')->index('batches_fk_course_id');
            $table->unsignedInteger('training_center_id')->index('batches_fk_training_id');
            $table->string('title_en', 191)->nullable();
            $table->string('title', 191);
            $table->string('code', 191);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedTinyInteger("batch_status")->nullable()->comment('1=>On Going Batch, 2=>Complete Batch');
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
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
        Schema::dropIfExists('batches');
    }
}
