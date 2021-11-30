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
            $table->unsignedInteger('user_id')->comment('trainer id');
            $table->unsignedInteger('youth_id');
            $table->unsignedInteger('examination_id');
            $table->unsignedInteger('achieved_marks');
            $table->tinyInteger('feedback')->nullable();
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
