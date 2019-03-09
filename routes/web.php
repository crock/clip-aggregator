<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/game/{slug}', 'GameController@index');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard')->middleware('auth');
Route::get('/clip/{id}', 'ClipController@index');

Route::get('/upload', 'ClipController@show_clip_submission_form')->name('clip-submission');
Route::post('/clip/submit', 'ClipController@submit')->name('submit-clip');

Auth::routes();

Route::get('/comments/{id}', 'CommentController@index');
Route::post('/comments', 'CommentController@store');
Route::put('/comments/{comment}', 'CommentController@update');
Route::delete('/comments/{comment}', 'CommentController@destroy');




