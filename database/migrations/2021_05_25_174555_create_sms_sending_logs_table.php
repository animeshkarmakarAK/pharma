<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsSendingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_sending_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sms_type', 300);
            $table->text('contacts')->nullable();
            $table->text('api_response')->nullable();
            $table->enum('content_type', ['unicode', 'text'])->default('text');
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
        Schema::dropIfExists('sms_sending_logs');
    }
}
