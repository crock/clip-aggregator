<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    use \Spatie\Tags\HasTags;

    protected $table = 'clips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'custom_title', 'url', 'twitch_clip_id', 'embed_url', 'game_id', 'language', 'clip_created_date', 'duration', 'view_count', 'broadcaster_id', 'curator_id', 'broadcaster_name', 'curator_name', 'video_id', 'tags', 'thumbnail_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
