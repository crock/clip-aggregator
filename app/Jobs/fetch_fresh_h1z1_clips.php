<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Carbon;
use App\Http\Controllers\ClipController;

class fetch_fresh_h1z1_clips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
		Carbon::setWeekStartsAt(Carbon::SUNDAY);
		Carbon::setToStringFormat(Carbon::RFC3339);

		$client = new HttpClient([
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout'  => 2.0
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$dt = Carbon::now('UTC');
		$startDate = $dt->subHour();
		$endDate = $dt->addHour();

		$qs = array(
			'game_id' => '417892',
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

		foreach ($response as $r) {
			if (Clip::where('twitch_clip_id', $r->id)->doesntExist()) {
				ClipController::add_clip($r);
			}
		}
    }
}
