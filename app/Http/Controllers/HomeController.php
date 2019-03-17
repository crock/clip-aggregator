<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class HomeController extends Controller
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
     * Show the application homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$games = Game::all();

        return view('home')->with(['games' => $games]);
	}

}
