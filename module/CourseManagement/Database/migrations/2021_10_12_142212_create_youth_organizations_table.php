<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youth_organizations', function (Blueprint $table) {
            /*$table->unsignedInteger('youth_id');
            $table->unsignedInteger('organization_id');

            $table->foreign('youth_id')
                ->references('id')
                ->on('youths')
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");*/

            $table->increments('id');
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('youth_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('youth_organizations');
    }
}
