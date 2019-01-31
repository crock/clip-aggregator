<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curator extends Model
{

    protected $table = 'curators';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'display_name', 'channel_url', 'logo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
