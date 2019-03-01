<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VOD extends Model
{
    protected $table = 'vods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'twitch_video_id', 'user_id', 'user_name', 'title', 'description', 'url', 'thumbnail_url', 'viewable', 'view_count', 'language', 'type', 'duration', 'video_created_date', 'published_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
