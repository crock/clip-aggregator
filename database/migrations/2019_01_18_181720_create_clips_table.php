<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clips', function (Blueprint $table) {
            $table->increments('id');
			$table->string('twitch_clip_id')->unique();

			$table->string('broadcaster_id');
			$table->string('broadcaster_name');
			$table->string('creator_id');
			$table->string('creator_name');
            $table->string('video_id');

			$table->string('title');
			$table->string('custom_title')->nullable();
            $table->string('url');
            $table->string('embed_url');
            $table->string('game_id');
            $table->string('language', 2);
			$table->integer('view_count');
			$table->string('thumbnail_url');
            $table->float('duration')->nullable();
            $table->string('clip_created_date');

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
		Schema::dropIfExists('clips');
    }
}
