<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Spatie\Regex\Regex;
use App\Clip;
use App\Game;
use DB;
use Illuminate\Support\Carbon;
use App\Jobs\StoreNewClips;

class ClipController extends Controller
{

	public $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->middleware('web');
    }

    /**
     * Show the individual clip page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$data = fetch_clip_details($request->id);
        if (Clip::where('twitch_clip_id', $request->id)->doesntExist()) {
			$this->add_clip($data);
		}
		$clipData = Clip::where('twitch_clip_id', $request->id)->get();
        return view('clip')->with([ 'clip' => $clipData ]);
	}

	public function show_clip_submission_form() {
		return view('submit');
	}

	public function add_clip($data) {
		$clip = new Clip;

		$clip->twitch_clip_id = $data['data'][0]['id'];
		$clip->custom_title = null;
		$clip->title = $data['data'][0]['title'];
		$clip->url = $data['data'][0]['url'];
		$clip->embed_url = $data['data'][0]['embed_url'];
		$clip->game_id = $data['data'][0]['game_id'];
		$clip->language = $data['data'][0]['language'];
		$clip->view_count = $data['data'][0]['view_count'];
		//$clip->duration = $data['data'][0]['duration'];
		$clip->clip_created_date = $data['data'][0]['created_at'];
		$clip->thumbnail_url = $data['data'][0]['thumbnail_url'];
		$clip->video_id = $data['data'][0]['video_id'];

		$clip->broadcaster_name = $data['data'][0]['broadcaster_name'];
		$clip->broadcaster_id = $data['data'][0]['broadcaster_id'];

		$clip->creator_name = $data['data'][0]['creator_name'];
		$clip->creator_id = $data['data'][0]['creator_id'];

		$clip->save();
	}

    public function submit(Request $request) {

        $tags = explode(',', $request->tags);

        $slug = Regex::match('/^https?:\/\/clips\.twitch\.tv\/([a-zA-Z]+)\??[\S]+$/', $request->url)->group(1);

        $data = fetch_clip_details($slug);

        if (DB::table('clips')->where('twitch_clip_id', $data['data'][0]['id'])->doesntExist()) {
			$customTitle = $request->title ? $request->title : null;

            $clip = new Clip;

            $clip->tags = $tags;

			$clip->twitch_clip_id = $data['data'][0]['id'];
			$clip->custom_title = $customTitle;
            $clip->title = $data['data'][0]['title'];
            $clip->url = $data['data'][0]['url'];
            $clip->embed_url = $data['data'][0]['embed_url'];
            $clip->game_id = $data['data'][0]['game_id'];
            $clip->language = $data['data'][0]['language'];
            $clip->view_count = $data['data'][0]['view_count'];
            //$clip->duration = $data['data'][0]['duration'];
			$clip->clip_created_date = $data['data'][0]['created_at'];
			$clip->thumbnail_url = $data['data'][0]['thumbnail_url'];
			$clip->video_id = $data['data'][0]['video_id'];

			$clip->broadcaster_name = $data['data'][0]['broadcaster_name'];
			$clip->broadcaster_id = $data['data'][0]['broadcaster_id'];

			$clip->creator_name = $data['data'][0]['creator_name'];
			$clip->creator_id = $data['data'][0]['creator_id'];

			$clip->save();

        } else {
            return "That clip has previously been submitted to the site.";
        }

	}

	/**
	 * Fetches details about clip id passed into function
	 * @param String $id
	 * @return view
	 */
	public function fetch_clip_details($id) {

		$this->client = new HttpClient([
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout'  => 2.0
		]);

		// Checks to see if ID that is passed into route is a Twitch clip slug
        if (Regex::match('/[a-zA-Z]+/', $id)->hasMatch()) {

			$qs = array(
				'id' => $id
			);

			$response = $this->client->request('get', 'clips', [
				'query' => $qs,
				'headers' => [
					'Client-ID' => ENV('TWITCH_CLIENT_ID')
				]
			]);

			$clips = json_decode($response->getBody(), true);
			StoreNewClips::dispatch($clips);

			return $clips;

		}

	}

    public function get_top_clips(Request $request) {
		$queryParam = strtolower($request->query('game'));
		$game = new \stdClass;

		if ($queryParam == "random") {
			$game = Game::all()->random(1);
		} else {
			$game = Game::where('slug', $queryParam)->get();
			if ($game == null) {
				$game = Game::all()->random(1);
			}
		}

		Carbon::setWeekStartsAt(Carbon::SUNDAY);
		Carbon::setToStringFormat(Carbon::RFC3339);

		$dt = Carbon::now('UTC');
		$startDate = '';

		if ($dt->dayOfWeek == 7) {
			$startDate = $dt->subWeek();
		} else {
			$startDate = $dt->startOfWeek();
		}

		$qs = array(
			'game_id' => $game[0]->game_id,
			'started_at' => $startDate->__toString()
		);

		$client = new HttpClient([
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout'  => 2.0
        ]);

        $response = $client->request('get', 'clips', [
            'query' => $qs,
            'headers' => [
                'Client-ID' => ENV('TWITCH_CLIENT_ID')
            ]
		]);

		$clips = json_decode($response->getBody(), true);
		StoreNewClips::dispatch($clips);

        return $response->getBody();

    }
}
