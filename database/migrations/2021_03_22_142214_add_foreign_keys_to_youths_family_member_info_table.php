<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToYouthsFamilyMemberInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youths_family_member_info', function (Blueprint $table) {
            $table->foreign('youth_id', 'youth_family_members_info')->references('id')->on('youths')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youths_family_member_info', function (Blueprint $table) {
            $table->dropForeign('youth_family_members_info');
        });
    }
}
