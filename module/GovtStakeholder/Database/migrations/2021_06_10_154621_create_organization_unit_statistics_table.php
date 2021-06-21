<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationUnitStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_unit_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organization_unit_id');
            $table->unsignedInteger('total_new_recruits');
            $table->unsignedInteger('total_vacancy');
            $table->unsignedInteger('total_occupied_position');
            $table->date('survey_date')->nullable();
            $table->timestamps();

            $table->foreign('organization_unit_id', 'organization_unit_statistics_fk_organization_unit_id')->references('id')->on('organization_units')->onUpdate('CASCADE')->onDelete('CASCADE');

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
