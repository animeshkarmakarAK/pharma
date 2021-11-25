<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRoutineClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routine_classes', function (Blueprint $table) {
            $table->foreign('routine_id', 'routine_classes_fk_routine_id')
                ->references('id')
                ->on('routines')
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
        Schema::table('routine_classes', function (Blueprint $table) {
            Schema::dropIfExists('routine_classes_fk_routine_id');
        });
    }
}
