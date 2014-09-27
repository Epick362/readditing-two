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
Route::get('/r/{subreddit}/comments/{thing}', 'FrontpageController@post');

Route::get('/submit/{subreddit?}', 'FrontpageController@submit');

Route::get('u/{user}/{category?}', 'ProfileController@index');

Route::get('/auth/login', 'AuthController@auth');

Route::get('about', function() {
	return Response::view('about');
});

// =============================================
// API ROUTES ==================================
// =============================================
Route::group(array('prefix' => 'api'), function() {
	Route::get('/r/{subreddit?}', 'ApiController@indexPost');
	Route::post('/submit', 'ApiController@storePost');

	Route::get('/u/{user}/{category?}', 'ApiController@indexProfile');

	Route::get('/r/{subreddit}/comments/{thing}', 'ApiController@indexComment');
	Route::post('/comment', 'ApiController@storeComment');

	Route::post('/vote/{id}', 'ApiController@storeVote');
	Route::delete('/vote/{id}', 'ApiController@destroyVote');

	Route::post('/save/{id}', 'ApiController@storeSave');
	Route::delete('/save/{id}', 'ApiController@destroySave');	

	Route::post('/subscribe/{id}', 'ApiController@storeSubscribe');
	Route::delete('/subscribe/{id}', 'ApiController@destroySubscribe');	
});