<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intro_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id');//->index('intro_videos_fk_institute_id');
            $table->string('youtube_video_url', 255)->nullable();
            $table->string('youtube_video_id', 191)->nullable();
            $table->unsignedTinyInteger('row_status')->default(1);
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
        Schema::dropIfExists('intro_videos');
    }
}
