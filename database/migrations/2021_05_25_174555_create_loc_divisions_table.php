<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loc_divisions', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('title', 300);
            $table->string('title_en', 191);
            $table->char('bbs_code', 2)->nullable();
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
        Schema::dropIfExists('loc_divisions');
    }
}
