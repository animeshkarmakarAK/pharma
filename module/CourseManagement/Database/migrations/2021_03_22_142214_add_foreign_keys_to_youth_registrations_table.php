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
            $table->foreign('publish_course_id', 'youth_registrations_fk_publish_course_id')->references('id')->on('publish_courses')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
            $table->dropForeign('youth_registrations_fk_publish_course_id');
            $table->dropForeign('youth_registrations_fk_youth_id');
        });
    }
}
