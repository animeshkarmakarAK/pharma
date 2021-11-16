<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationEfficientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_efficients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organization_information_id');
            $table->string('employee_level_occupation')->nullable();
            $table->string('senior_level_occupation')->nullable();
            $table->string('middle_level_occupation')->nullable();
            $table->string('junior_level_occupation')->nullable();
            $table->foreign('organization_information_id')->references('id')->on('organization_informations')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('organization_efficients');
    }
}
