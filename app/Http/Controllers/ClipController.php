<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Spatie\Regex\Regex;
use App\Clip;
use App\Game;
use DB;

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

		$this->client = new HttpClient([
            'base_uri' => 'https://api.twitch.tv/helix/',
            'timeout'  => 3.0
		]);
    }

    /**
     * Show the individual clip page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$data = $this->fetch_clip_details($request->id);
        if (Clip::where('twitch_clip_id', $request->id)->doesntExist()) {
			$this->add_clip($data[0]);
		}
		$clipData = Clip::where('twitch_clip_id', $request->id)->get();
		$games = Game::all();
        return view('clip')->with([ 'clip' => $clipData, 'games' => $games ]);
	}

	public function show_clip_submission_form() {
		$games = Game::all();
		return view('submit')->with(['games' => $games]);
	}

	public function add_clip($data) {
		$clip = new Clip;

		$clip->twitch_clip_id = $data['id'];
		$clip->custom_title = null;
		$clip->title = $data['title'];
		$clip->url = $data['url'];
		$clip->embed_url = $data['embed_url'];
		$clip->game_id = $data['game_id'];
		$clip->language = $data['language'];
		$clip->view_count = $data['view_count'];
		//$clip->duration = $data['duration'];
		$clip->clip_created_date = $data['created_at'];
		$clip->thumbnail_url = $data['thumbnail_url'];
		$clip->video_id = $data['video_id'];

		$clip->broadcaster_name = $data['broadcaster_name'];
		$clip->broadcaster_id = $data['broadcaster_id'];

		$clip->creator_name = $data['creator_name'];
		$clip->creator_id = $data['creator_id'];

		$clip->save();
	}

    public function submit(Request $request) {

		$slug = "";

		$patt1 = "/^https?:\/\/www\.twitch\.tv\/[a-zA-Z0-9_]+\/clip\/([a-zA-Z0-9]+)/";
		$patt2 = "/^https?:\/\/clips\.twitch\.tv\/([a-zA-Z0-9]+)/";

		if (Regex::match($patt1, $request->url)->hasMatch()) {
			$slug = Regex::match($patt1, $request->url)->group(1);
		} else if (Regex::match($patt2, $request->url)->hasMatch()) {
			$slug = Regex::match($patt2, $request->url)->group(1);
		}

		$data = $this->fetch_clip_details($slug);

        if (DB::table('clips')->where('twitch_clip_id', $data[0]['id'])->doesntExist()) {
			$this->add_clip($data[0]);
		}

		return redirect('/clip/' . $slug);

	}

	/**
	 * Fetches details about clip id passed into function
	 * @param String $id
	 * @return view
	 */
	public function fetch_clip_details($id) {

		// Checks to see if ID that is passed into route is a Twitch clip slug
        if (Regex::match('/[a-zA-Z0-9]+/', $id)->hasMatch()) {

			$qs = array(
				'id' => $id
			);

			$response = $this->client->request('get', 'clips', [
				'query' => $qs,
				'headers' => [
					'Client-ID' => ENV('TWITCH_CLIENT_ID')
				]
			]);

			$clips = json_decode($response->getBody(), true)['data'];

			return $clips;

		}

	}

	public function fetch_single_clip_from_twitch_api($id) {

		// Checks to see if ID that is passed into route is a Twitch clip slug
        if (Regex::match('/[a-zA-Z0-9]+/', $id)->hasMatch()) {

			$qs = array(
				'id' => $id
			);

			$response = $this->client->request('get', 'clips', [
				'query' => $qs,
				'headers' => [
					'Client-ID' => ENV('TWITCH_CLIENT_ID')
				]
			]);

			$clip = json_decode($response->getBody(), true)['data'][0];

			return $clip;

		}

	}

	public function getTotal() {
		$data = Clip::all()->count();

		return response()->json(['total' => $data]);
	}

	public function getClipById(Request $request) {
		$clip = Clip::where('twitch_clip_id', $request->clipId);
		if ($clip->exists()) {
			return response()->json($clip);
		} else {
			$data = $this->fetch_single_clip_from_twitch_api($request->clipId);
			return response()->json($data);
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

		$clips = Clip::where('game_id', '=', $game[0]->game_id)
		->latest()
		->orderBy('view_count', 'DESC')
		->limit(30)
		->get();

		return response()->json($clips);

	}

	public function get_random_clips() {
		$clips = Clip::where('view_count', '>=', 100)
		->inRandomOrder()
		->limit(30)
		->get();

		return response()->json($clips);
	}
}
