<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFormTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_form_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->index('application_form_types_fk_institute_id');
            $table->string('title_en', 191)->nullable();
            $table->string('title_bn', 191)->nullable();
            $table->tinyInteger('ethnic')->nullable()->default(0)->comment("1 => in ethnic group, 2 => not in ethnic group");
            $table->tinyInteger('freedom_fighter')->nullable()->default(0);
            $table->tinyInteger('disable_status')->nullable()->default(0)->comment('1 => disable  2 => not disable');
            $table->tinyInteger('ssc')->nullable()->default(0)->comment('is passed ssc');
            $table->tinyInteger('hsc')->nullable()->default(0)->comment('is passed hsc');
            $table->tinyInteger('honors')->nullable()->default(0)->comment('is passed honors');
            $table->tinyInteger('masters')->nullable()->default(0)->comment('is passed masters');
            $table->tinyInteger('occupation')->nullable()->default(0)->comment('is occupation needed');
            $table->tinyInteger('guardian')->nullable()->default(0)->comment('is guardian information needed');
            $table->unsignedTinyInteger('row_status')->default(1);
            $table->unsignedInteger('created_by')->nullable();
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
        Schema::dropIfExists('application_form_types');
    }
}
