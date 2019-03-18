<?php

namespace App\Http\Controllers;

use App\Clip;
use App\Game;
use Illuminate\Http\Request;

class SearchController extends Controller
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

	public function index(Request $request) {
		$games = Game::all();
		return view('search')->with(['query' => $request->query('q'), 'games' => $games]);
	}

	public function search(Request $request)
	{
		$clips = Clip::where('title', 'LIKE', "%{$request->query('q')}%")
		->limit(5)
		->get();

		return response()->json($clips);
	}

	public function all_search_results(Request $request)
	{
		return Clip::where('title', 'LIKE', "%{$request->query('q')}%")->paginate(15);
	}
}
