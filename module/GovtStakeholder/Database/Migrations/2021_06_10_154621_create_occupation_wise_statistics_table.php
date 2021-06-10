<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccupationWiseStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupation_wise_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->index('occupation_wise_statistics_fk_institute_id');
            $table->unsignedInteger('occupation_id')->index('occupation_wise_statistics_fk_occupation_id');
            $table->unsignedInteger('current_month_skilled_people')->default(0);
            $table->unsignedInteger('next_month_skill_people')->default(0);
            $table->unsignedTinyInteger('row_status')->default(1);
            $table->timestamps();

            $table->foreign('institute_id', 'occupation_wise_statistics_fk_institute_id')->references('id')->on('institutes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('occupation_id', 'occupation_wise_statistics_fk_occupation_id')->references('id')->on('occupations')->onUpdate('CASCADE')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occupation_wise_statistics');
    }
}
