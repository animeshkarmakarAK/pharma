<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocUpazilasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loc_upazilas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_en', 350);
            $table->string('title_bn', 250);
            $table->unsignedMediumInteger('loc_division_id')->index('loc_upazilas_loc_division_id_foreign');
            $table->unsignedMediumInteger('loc_district_id')->index('loc_upazilas_loc_district_id_foreign');
            $table->char('district_bbs_code', 3)->nullable();
            $table->boolean('is_sadar_upazila')->default(0);
            $table->unsignedTinyInteger('row_status')->default(1)->index()->comment('1 => Active, 0 => Deactivate, 99 => Deleted');
            $table->unsignedInteger('created_by')->default(0);
            $table->unsignedInteger('updated_by')->default(0);
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
        Schema::dropIfExists('loc_upazilas');
    }
}
