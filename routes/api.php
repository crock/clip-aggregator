<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clips/all', function () {
    return App\Clip::simplePaginate(100);
});
Route::get('/clips/total', 'ClipController@getTotal');
Route::get('/clips/top', 'ClipController@get_top_clips');
Route::get('/clips/random', 'ClipController@get_random_clips');
Route::get('/clips/{clipId}', 'ClipController@getClipById');
Route::get('/games/list', 'GameController@get_games');
Route::get('/game/{game}', 'GameController@get_game');
Route::get('/users/twitch', 'UserController@get_twitch_users');
Route::get('/search', 'SearchController@search');
Route::get('/search/results', 'SearchController@all_search_results');
