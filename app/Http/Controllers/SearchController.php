<?php

namespace App\Http\Controllers;

use App\Clip;
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

	public function search(Request $request)
	{
		$clips = Clip::where('title', 'LIKE', "%{$request->query('q')}%")->get();

		return response()->json($clips);
	}
}
