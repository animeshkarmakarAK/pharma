<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loc_districts', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('title', 300);
            $table->string('title_en', 250)->nullable();
            $table->char('bbs_code', 3)->nullable();
            $table->unsignedMediumInteger('loc_division_id')->index('loc_districts_loc_division_id_foreign');
            $table->boolean('is_sadar_district')->nullable()->default(0);
            $table->unsignedTinyInteger('row_status')->default(1)->index()->comment('1 => Active, 0 => Deactivate, 99 => Deleted');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('loc_districts');
    }
}
