<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vods', function (Blueprint $table) {
			$table->increments('id');

			$table->string('twitch_video_id');
			$table->string('user_id');
			$table->string('user_name');
			$table->string('title');
			$table->string('description');
			$table->string('url');
			$table->string('thumbnail_url');
			$table->string('viewable');
			$table->string('view_count');
			$table->string('language');
			$table->string('type');
			$table->string('duration');
			$table->string('video_created_date');
			$table->string('published_at');

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
        Schema::dropIfExists('vods');
    }
}
