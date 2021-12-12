<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToYouthCourseEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youth_course_enrolls', function (Blueprint $table) {
            $table->foreign('youth_id', 'youth_course_enrolls_fk_youth_id')
                ->references('id')
                ->on('youths')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('course_id', 'youth_course_enrolls_fk_course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youth_course_enrolls', function (Blueprint $table) {
            $table->dropForeign('youth_course_enrolls_fk_youth_id');
            $table->dropForeign('youth_course_enrolls_fk_course_id');
        });
    }
}
