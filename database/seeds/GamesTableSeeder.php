<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('games')->get()->count() == 0) {

				DB::table('games')->insert([
				[
					'id' => 1,
					'game_id' => '493057',
					'name' => 'PLAYERUNKNOWN\'S BATTLEGROUNDS',
					'slug' => 'pubg',
					'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/PLAYERUNKNOWN%27S%20BATTLEGROUNDS-150x200.jpg',
					'cover_image' => '/images/pubg01.jpg',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				],
				[
					'id' => 2,
					'game_id' => '511224',
					'name' => 'Apex Legends',
					'slug' => 'apex',
					'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/Apex%20Legends-150x200.jpg',
					'cover_image' => '/images/apex02.jpg',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				],
				[
					'id' => 3,
					'game_id' => '33214',
					'name' => 'Fortnite',
					'slug' => 'fortnite',
					'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/Fortnite-150x200.jpg',
					'cover_image' => '/images/fortnite01.jpg',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				],
				[
					'id' => 4,
					'game_id' => '417892',
					'name' => 'H1Z1',
					'slug' => 'h1z1',
					'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/H1Z1-150x200.jpg',
					'cover_image' => '/images/h1z101.jpg',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]
			]);

        }
    }
}
