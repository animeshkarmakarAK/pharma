<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaineeCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tainee_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('batch_certificate_id')->index('batch_certificates_fk_batch_certificate_id');
            $table->unsignedInteger('batch_id')->index('batches_fk_batch_id');
            $table->unsignedInteger('trainee_id')->index('trainees_fk_trainee_id');
            $table->date('date_of_birth');
            $table->string('name', 191);
            $table->string('father_name', 191);
            $table->string('mother_name', 191);
            $table->string('uuid', 191);
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
            $table->timestamps();
        });
    }



//TODO:not done user_id: batch_id

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tainee_certificates');
    }
}
