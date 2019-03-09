<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
	$user = factory(App\User::class)->create();
	$clip = factory(App\Clip::class)->create();

    return [
		'user_id' => $user->id,
		'clip_id' => $clip->id,
        'body' => $faker->sentence,
    ];
});
