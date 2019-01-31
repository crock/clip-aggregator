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
            $table->increments('id')->unsigned();

            $table->integer('broadcaster_id')->unsigned(10)->nullable();
            $table->integer('curator_id')->unsigned(10)->nullable();
            $table->integer('vod_id')->unsigned(10)->nullable();

            $table->integer('tracking_id')->unsigned(10)->unique();
            $table->string('title');
            $table->string('slug');
            $table->string('url');
            $table->string('embed_url');
            $table->string('game');
            $table->string('language', 2);
            $table->integer('views');
            $table->float('duration');
            $table->string('clip_created_date');
            $table->timestamp('dated_added');
        });

        Schema::create('broadcasters', function (Blueprint $table) {
            $table->integer('id')->primary()->unsigned(10)->unique();
            $table->string('name');
            $table->string('display_name');
            $table->string('channel_url');
            $table->string('logo');
            $table->timestamps();
        });

        Schema::create('curators', function (Blueprint $table) {
            $table->integer('id')->primary()->unsigned(10)->unique();
            $table->string('name');
            $table->string('display_name');
            $table->string('channel_url');
            $table->string('logo');
            $table->timestamps();
        });

        Schema::create('vods', function (Blueprint $table) {
            $table->integer('id')->primary()->unsigned(10)->nullable()->unique();
            $table->string('url')->nullable();
        });

        Schema::create('thumbnails', function (Blueprint $table) {
            $table->integer('id')->primary()->unsigned(10)->unique();
            $table->string('medium');
            $table->string('small');
            $table->string('tiny');
        });

        Schema::table('clips', function (Blueprint $table) {
            $table->foreign('broadcaster_id')->references('id')->on('broadcasters')->onUpdate('cascade');
            $table->foreign('curator_id')->references('id')->on('curators')->onUpdate('cascade');
            $table->foreign('vod_id')->references('id')->on('vods')->onUpdate('cascade');
        });

        Schema::table('thumbnails', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('clips')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clips', function (Blueprint $table) {
            $table->dropForeign(['broadcaster_id']);
            $table->dropForeign(['curator_id']);
            $table->dropForeign(['vod_id']);
        });

        Schema::dropIfExists('broadcasters');
        Schema::dropIfExists('curators');
        Schema::dropIfExists('vods');

        Schema::table('thumbnails', function (Blueprint $table) {
            $table->dropForeign(['id']);
            $table->dropIfExists('thumbnails');
        });
    }
}
