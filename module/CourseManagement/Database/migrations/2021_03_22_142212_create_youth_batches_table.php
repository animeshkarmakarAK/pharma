<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youth_batches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('batch_id')->index('youth_batches_fk_batch_id');
            $table->unsignedInteger('youth_course_enroll_id');
            /*$table->unsignedInteger('youth_registration_id')->index('youth_batches_fk_youth_registration_id');
            $table->unsignedInteger('youth_id')->index('youth_batches_fk_youth_id');*/
            $table->date('enrollment_date');
            $table->unsignedTinyInteger('enrollment_status');
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
        Schema::dropIfExists('youth_batches');
    }
}
