<?php

namespace App\Http\Controllers\Auth;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class TwitchSSO extends Controller
{
	use AuthenticatesUsers;

	/**
     * Where to redirect users after login.
     *
     * @var string
     */
	protected $redirectTo = '/';

	public $baseAuthUrl = 'https://id.twitch.tv/oauth2/authorize';
	public $baseTokenUrl = 'https://id.twitch.tv/oauth2/token';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->middleware('guest')->except('logout');
	}

	protected function getDefaultHeaders()
    {
        return ['Client-ID' => env('TWITCH_CLIENT_ID'), 'Accept' => 'application/vnd.twitchtv.v5+json'];
    }
    protected function getAuthorizationHeaders($token = NULL)
    {
        return ['Authorization' => 'Bearer '.$token];
    }
}
