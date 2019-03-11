<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Carbon;
use App\Http\Controllers\ClipController;
use App\Jobs\StoreNewClips;
use App\Game;

class FetchFreshClips extends Command
{

	protected $client;
	protected $cc;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:clips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch fresh clips from the Twitch API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();

		Carbon::setWeekStartsAt(Carbon::SUNDAY);
		Carbon::setToStringFormat(Carbon::RFC3339);

		$this->client = new HttpClient([
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout'  => 2.0
		]);

		$this->cc = new ClipController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$games = Game::all();

		foreach ($games as $game) {
			$dt = Carbon::now('UTC');
			$startDate = $dt->subHour();
			$endDate = $dt->addHour();

			$qs = array(
				'game_id' => $game->game_id,
				'started_at' => $startDate->__toString(),
				'ended_at' => $endDate->__toString(),
				'first' => 100
			);

			$response = $this->client->request('get', 'clips', [
				'query' => $qs,
				'headers' => [
					'Client-ID' => ENV('TWITCH_CLIENT_ID')
				]
			]);

			$response = json_decode($response->getBody(), true);

			StoreNewClips::dispatch($response);
		}

    }
}
