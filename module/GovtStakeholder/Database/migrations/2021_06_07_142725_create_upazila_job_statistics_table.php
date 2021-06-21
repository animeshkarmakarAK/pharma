<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpazilaJobStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upazila_job_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('loc_upazila_id')->index('upazila_job_statistics_fk_loc_upazila_id');
            $table->unsignedInteger('job_sector_id')->index('upazila_job_statistics_fk_job_sector_id');
            $table->unsignedInteger('total_unemployed')->nullable();
            $table->unsignedInteger('total_employed')->nullable();
            $table->unsignedInteger('total_vacancy')->nullable();
            $table->unsignedInteger('total_new_recruitment')->nullable();
            $table->unsignedInteger('total_new_skilled_youth')->nullable();
            $table->unsignedInteger('total_skilled_youth')->nullable();
            $table->date('survey_date')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedTinyInteger('row_status')->default(1);
            $table->timestamps();
            $table->foreign('job_sector_id')->references('id')->on('job_sectors')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upazila_job_statistics');
    }
}
