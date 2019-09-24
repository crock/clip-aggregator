<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use App\Clip;
use App\Game;
use Carbon\Carbon;

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
			->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS))
			->add(Url::create('/upload')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
			->add(Url::create('/login')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
			->add(Url::create('/register')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
			->add(Url::create('/password/reset')->setPriority(0.4)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
			->writeToFile(public_path('sitemaps/pages_sitemap.xml'));
		$this->line('Pages sitemap generated.');

		$games_sitemap = Sitemap::create();
		Game::all()->each(function (Game $game) use ($games_sitemap) {
			$games_sitemap->add(Url::create("/game/{$game->slug}")
			->setPriority(0.9)
			->setLastModificationDate($game->updated_at)
			->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS));
		});
		$games_sitemap->writeToFile(public_path('sitemaps/games_sitemap.xml'));
		$this->line('Games sitemap generated.');

		$clips_index = SitemapIndex::create();
		$clips = Clip::all();
		$numClips = $clips->count();
		$numSitemaps = round($numClips / 10000);
		$currentSitemap = 0;
		$marker = 1;
		while ($marker < $numClips) {
			
			while ($currentSitemap < $numSitemaps) {

				$sitemap = Sitemap::create();
				$x = 1;
				while ( $x <= 10000) {
					if ($x === 10000) {
						break;
					}
					if (!empty($clips[$marker - 1])) {
						$sitemap->add(
							Url::create("/clip/{$clips[$marker - 1]->twitch_clip_id}")
								->setPriority(0.6)
								->setLastModificationDate($clips[$marker - 1]->updated_at)
								->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
						);
						$this->line("Added /clip/{$clips[$marker - 1]->twitch_clip_id}");
					}
					$marker++;
					$x++;
				}

				$sitemap->writeToFile(public_path("sitemaps/clips/clips_sitemap_{$currentSitemap}.xml"));
				$this->line("Clips No. {$currentSitemap} sitemap generated.");

				$clips_index->add("/sitemaps/clips/clips_sitemap_{$currentSitemap}.xml");
				$currentSitemap++;

				if ( $currentSitemap === $numSitemaps ) {
					break;
				}

			}

			if ( $marker === $numClips ) {
				break;
			}
		}
		$clips_index->writeToFile(public_path('/sitemaps/clips_sitemap.xml'));
		$this->line("Clips sitemap index generated.");

		SitemapIndex::create()
			->add('/sitemaps/pages_sitemap.xml')
			->add('/sitemaps/games_sitemap.xml')
			->add('/sitemaps/clips_sitemap.xml')
			->writeToFile(public_path('sitemap.xml'));
		$this->line("Global sitemap generated.");

    }
}
