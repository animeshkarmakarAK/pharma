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
            $table->foreign('course_id', 'batches_fk_course_id')->references('id')->on('courses')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('training_center_id', 'batches_fk_training_center_id')->references('id')->on('courses')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
            $table->dropForeign('batches_fk_course_id');
        });
    }
}
