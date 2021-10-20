<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseWiseYouthCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_wise_youth_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('publish_course_id');
            $table->unsignedInteger('youth_id');
            $table->unsignedInteger('certificate_path')->nullable();
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
        Schema::dropIfExists('youth_organizations');
    }
}
