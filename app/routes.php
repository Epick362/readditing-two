<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'FrontpageController@subreddit');

Route::get('/r/{subreddit?}', 'FrontpageController@subreddit');

Route::get('/auth/login', 'AuthController@auth');

Route::get('/test', function() {
	echo '<pre>';
	print_r(Reddit::fetch('/hot.json'));
	return;
});