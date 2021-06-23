<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrganizationUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_unit_types', function (Blueprint $table) {
            $table->foreign('organization_id', 'organization_unit_types_fk_organization_id')->references('id')->on('organizations')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_unit_types', function (Blueprint $table) {
            $table->dropForeign('organization_unit_types_fk_organization_id');
        });
    }
}
