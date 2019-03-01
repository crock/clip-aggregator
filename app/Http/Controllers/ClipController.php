<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Spatie\Regex\Regex;
use App\Http\Resources\Clip as ClipResource;
use App\Clip;
use App\Broadcaster;
use App\Curator;
use App\VOD;
use App\Thumbnail;
use DB;
use Illuminate\Support\Carbon;

class ClipController extends Controller
{

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
		$clipData = $this->fetch_clip_details($request->id);
        return view('clip')->with([ 'clip' => $clipData ]);
	}

	public function show_clip_submission_form() {
		return view('submit');
	}

    public function submit(Request $request) {

        $tags = explode(',', trim($request->tags));

        $slug = Regex::match('/^https?:\/\/clips\.twitch\.tv\/([a-zA-Z]+)\??[\S]+$/', trim($request->url))->group(1);

        $data = $this->fetch_clip_details($slug);

        if (DB::table('clips')->where('twitch_clip_id', $data['id'])->doesntExist()) {
			$customTitle = trim($request->title) != "" ? trim($request->title) : "";

            $clip = new Clip;

            $clip->tags = $tags;

			$clip->twitch_clip_id = $data['id'];
			$clip->custom_title = $customTitle;
            $clip->title = $data['title'];
            $clip->url = $data['url'];
            $clip->embed_url = $data['embed_url'];
            $clip->game_id = $data['game_id'];
            $clip->language = $data['language'];
            $clip->views = $data['view_count'];
            //$clip->duration = $data['duration'];
			$clip->clip_created_date = $data['created_at'];
			$clip->thumbnial_url = $data['thumbnail_url'];
			$clip->video_id = $data['video_id'];

			$clip->broadcaster_name = $data['broadcaster_name'];
			$clip->broadcaster_id = $data['broadcaster_id'];

			$clip->curator_name = $data['curator_name'];
			$clip->curator_id = $data['curator_id'];

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

		// Checks to see if ID that is passed into route is a Twitch clip slug
        if (Regex::match('/[a-zA-Z]+/', $id)->hasMatch()) {
			$client = new HttpClient([
				'base_uri' => 'https://api.twitch.tv/helix/',
				'timeout'  => 2.0
			]);

				$qs = array(
				'id' => $id
			);

				$response = $client->request('get', 'clips', [
				'query' => $qs,
				'headers' => [
					'Client-ID' => ENV('TWITCH_CLIENT_ID')
				]
			]);

			return json_decode($response->getBody(), true);

		}

	}

    public function get_top_clips(Request $request) {

		$game = DB::table('games')->where('slug', $request->query('game'))->first();

        $client = new HttpClient([
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout'  => 2.0
        ]);

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
			'game_id' => $game->game_id,
			'started_at' => $startDate->__toString()
        );

        $response = $client->request('get', 'clips', [
            'query' => $qs,
            'headers' => [
                'Client-ID' => ENV('TWITCH_CLIENT_ID')
            ]
        ]);

        return $response->getBody();

    }
}
