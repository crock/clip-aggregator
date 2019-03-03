<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;

class UserController extends Controller
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

    public function get_twitch_users(Request $request) {

		$client = new HttpClient([
			'base_uri' => 'https://api.twitch.tv/helix/',
			'timeout'  => 2.0
		]);

		$params = array();
		$idList = explode(',', $request->query('id'));

		foreach ($idList as $id) {
			array_push($params, "id=" . $id);
		}

		$qs = join('&', $params);

		$response = $client->request('get', 'users', [
			'query' => $qs,
			'headers' => [
				'Client-ID' => ENV('TWITCH_CLIENT_ID')
			]
		]);

		return $response->getBody();

	}
}
