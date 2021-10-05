<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToYouthBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youth_batches', function (Blueprint $table) {
            $table->foreign('batch_id', 'youth_batches_fk_batch_id')->references('id')->on('batches')->onUpdate('CASCADE')->onDelete('CASCADE');
            //$table->foreign('youth_id', 'youth_batches_fk_youth_id')->references('id')->on('youths')->onUpdate('CASCADE')->onDelete('CASCADE');
            //$table->foreign('youth_registration_id', 'youth_batches_fk_youth_registration_id')->references('id')->on('youth_registrations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youth_batches', function (Blueprint $table) {
            $table->dropForeign('youth_batches_fk_batch_id');
            $table->dropForeign('youth_batches_fk_youth_id');
            $table->dropForeign('youth_batches_fk_youth_registration_id');
        });
    }
}
