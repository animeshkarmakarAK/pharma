<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthCourseEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youth_course_enrolls', function (Blueprint $table) {
            $table->increments('id');
                $table->unsignedInteger('youth_id')->index('youth_course_enrolls_fk_youth_id');
            $table->unsignedInteger('course_id')->nullable()->index('youth_course_enrolls_fk_course_id');
            $table->unsignedTinyInteger('enroll_status')->nullable()->default(0)->comment('0 => Processing  1 => Accept 2 => Reject');
            $table->unsignedTinyInteger('payment_status')->nullable()->default(0)->comment('0 => Unpaid  1 => Paid');
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
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
        Schema::dropIfExists('youth_course_enrolls');
    }
}
