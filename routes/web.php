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

Route::redirect('/', '/e', 301);

Route::prefix('e')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/clip/{id}', 'ClipController@getClip');

    Route::get('/upload', 'ClipController@index')->name('clip-submission');
    Route::post('/clip/submit', 'ClipController@submit')->name('submit-clip');

    Auth::routes();
});



