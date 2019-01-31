<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    use \Spatie\Tags\HasTags;

    protected $table = 'clips';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'url', 'tracking_id', 'slug', 'embed_url', 'game', 'language', 'clip_created_date', 'duration', 'views', 'broadcaster_id', 'curator_id', 'vod_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'tags'
    ];
}
