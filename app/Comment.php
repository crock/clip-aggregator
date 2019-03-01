<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Clip;

class Comment extends Model
{
    protected $fillable = [
		'body',
		'user_id',
	];

	protected $casts = [
		'user_id' => 'integer',
	];

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function clip()
	{
		return $this->belongsTo(Clip::class, 'clip_id');
	}
}
