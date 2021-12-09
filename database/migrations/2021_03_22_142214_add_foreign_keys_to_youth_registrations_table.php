<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToYouthRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youth_registrations', function (Blueprint $table) {
            $table->foreign('course_id', 'youth_registrations_fk_course_id')->references('id')->on('courses')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('youth_id', 'youth_registrations_fk_youth_id')->references('id')->on('youths')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youth_registrations', function (Blueprint $table) {
            $table->dropForeign('youth_registrations_fk_course_id');
            $table->dropForeign('youth_registrations_fk_youth_id');
        });
    }
}
