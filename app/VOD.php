<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VOD extends Model
{
    protected $table = 'vods';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
