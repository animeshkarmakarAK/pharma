<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->index('routine_classes_fk_institute_id');
            $table->unsignedInteger('routine_id')->index('routine_classes_fk_routine_id');
            $table->unsignedInteger('user_id')->index('routine_classes_fk_user_id');
            //$table->string('day',256)->nullable();
            $table->string('class',256)->nullable()->nullable();
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
        Schema::dropIfExists('routine_classes');
    }
}
