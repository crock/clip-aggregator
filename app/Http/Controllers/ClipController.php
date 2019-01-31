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

class ClipController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('submit');
    }

    public function submit(Request $request) {

        $tags = explode(',', trim($request->tags));

        $slug = Regex::match('/^https?:\/\/clips\.twitch\.tv\/([a-zA-Z]+)\??[\S]+$/', trim($request->url))->group(1);

        $data = $this->getClipDetails($slug);

        if (DB::table('clips')->where('tracking_id', intval($data['tracking_id']))->doesntExist()) {
            $title = trim($request->title) == false ? $data['title'] : $request->title;

            $clip = new Clip;

            $clip->tags = $tags;

            $clip->tracking_id = intval($data['tracking_id']);
            $clip->title = $title;
            $clip->slug = $slug;
            $clip->url = $data['url'];
            $clip->embed_url = $data['embed_url'];
            $clip->game = $data['game'];
            $clip->language = $data['language'];
            $clip->views = $data['views'];
            $clip->duration = $data['duration'];
            $clip->clip_created_date = $data['created_at'];

            if ($data['vod'] != null) {
                $clip->vod_id = intval($data['vod']['id']);

                if (DB::table('vods')->where('id', intval($data['vod']['id']))->doesntExist()) {
                    $vod = new VOD;
                    $vod->id = intval($data['vod']['id']);
                    $vod->url = $data['vod']['url'];
                    $vod->save();
                }
            }

            if (DB::table('broadcasters')->where('id', intval($data['broadcaster']['id']))->doesntExist()) {
                $broadcaster = new Broadcaster;
                $broadcaster->id = intval($data['broadcaster']['id']);
                $broadcaster->name = $data['broadcaster']['name'];
                $broadcaster->display_name = $data['broadcaster']['display_name'];
                $broadcaster->channel_url = $data['broadcaster']['channel_url'];
                $broadcaster->logo = $data['broadcaster']['logo'];
                $broadcaster->save();
            }

            if (DB::table('curators')->where('id', intval($data['curator']['id']))->doesntExist()) {
                $curator = new Curator;
                $curator->id = intval($data['curator']['id']);
                $curator->name = $data['curator']['name'];
                $curator->display_name = $data['curator']['display_name'];
                $curator->channel_url = $data['curator']['channel_url'];
                $curator->logo = $data['curator']['logo'];
                $curator->save();
            }

            $clip->broadcaster_id = intval($data['broadcaster']['id']);
            $clip->curator_id = intval($data['curator']['id']);

            $clip->save();

            $clipRecord = Clip::where('tracking_id', intval($data['tracking_id']))->first();

            if (DB::table('thumbnails')->where('id', $clipRecord->id)->doesntExist()) {
                $thumb = new Thumbnail;
                $thumb->id = $clipRecord->id;
                $thumb->medium = $data['thumbnails']['medium'];
                $thumb->small = $data['thumbnails']['small'];
                $thumb->tiny = $data['thumbnails']['tiny'];
                $thumb->save();
            }
        } else {
            return "That clip has previously been submitted to the site.";
        }

    }

    public function getClipDetails($slug) {

        $client = new HttpClient([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.twitch.tv/kraken/',
            // You can set any number of default request options.
            'timeout'  => 2.0
        ]);

        // Checks to see if ID that is passed into route is a Twitch clip slug
        if (Regex::match('/[a-zA-Z]+/', $slug)->hasMatch()) {
            $response = $client->request('get', "clips/$slug", [
                'headers' => [
                    'Accept' => 'application/vnd.twitchtv.v5+json',
                    'Client-ID' => ENV('TWITCH_CLIENT_ID')
                ]
            ]);

            $clipData = $response->getBody();
            return json_decode($clipData, true);
        }
    }

    public function getClip(Request $request) {

        $client = new HttpClient([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.twitch.tv/kraken/',
            // You can set any number of default request options.
            'timeout'  => 2.0
        ]);

        // Checks to see if ID that is passed into route is a Twitch clip slug
        if (Regex::match('/[a-zA-Z]+/', $request->id)->hasMatch()) {

            $response = $client->request('get', "clips/$request->id", [
                'headers' => [
                    'Accept' => 'application/vnd.twitchtv.v5+json',
                    'Client-ID' => ENV('TWITCH_CLIENT_ID')
                ]
            ]);

            $clipData = $response->getBody();

            return view('clip')->with([ 'clip' => json_decode($clipData) ]);
        }
    }

    public function getTopClips() {

        $client = new HttpClient([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.twitch.tv/kraken/',
            // You can set any number of default request options.
            'timeout'  => 2.0
        ]);

        $qs = array(
            "game" => "fortnite",
            "language" => "en",
            "limit" => 100,
            "period" => "day",
            "trending" => true
        );

        $response = $client->request('get', 'clips/top', [
            'query' => $qs,
            'headers' => [
                'Accept' => 'application/vnd.twitchtv.v5+json',
                'Client-ID' => ENV('TWITCH_CLIENT_ID')
            ]
        ]);

        return $response->getBody();

    }
}
