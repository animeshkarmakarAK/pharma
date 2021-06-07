<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('url', 300);
            $table->text('parameters')->nullable();
            $table->enum('api_type', ['one_to_many', 'many_to_many'])->default('many_to_many');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_configs');
    }
}
