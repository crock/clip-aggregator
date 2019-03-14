<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
//use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
//use Illuminate\Support\Carbon;
use App\Clip;
use App\Game;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		Sitemap::create()
			->add(Url::create('/')->setPriority(1.0))
			->add(Url::create('/upload')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
			->add(Url::create('/login')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
			->add(Url::create('/register')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
			->add(Url::create('/password/reset')->setPriority(0.4)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
			->writeToFile(public_path('pages_sitemap.xml'));

		$games_sitemap = Sitemap::create();
		Game::all()->each(function (Game $game) use ($games_sitemap) {
			$games_sitemap->add(Url::create("/game/{$game->slug}")->setPriority(0.9)->setLastModificationDate($game->updated_at)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
		});
		$games_sitemap->writeToFile(public_path('games_sitemap.xml'));

		$clips_sitemap = Sitemap::create();
		Clip::all()->each(function (Clip $clip) use ($clips_sitemap) {
			$clips_sitemap->add(Url::create("/clip/{$clip->twitch_clip_id}")->setPriority(0.6)->setLastModificationDate($clip->updated_at)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
		});
		$clips_sitemap->writeToFile(public_path('clips_sitemap.xml'));

		// SitemapIndex::create()
		// 	->add(Url::create('/pages_sitemap.xml')->setLastModificationDate(Carbon::today())->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
		// 	->add(Url::create('/games_sitemap.xml')->setLastModificationDate(Carbon::today())->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
		// 	->add(Url::create('/clips_sitemap.xml')->setLastModificationDate(Carbon::today())->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
		// 	->writeToFile(public_path('sitemap.xml'));

    }
}
