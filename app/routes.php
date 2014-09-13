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

// =============================================
// API ROUTES ==================================
// =============================================
Route::group(array('prefix' => 'api'), function() {
	Route::get('/r/{subreddit?}', 'ApiController@subreddit');

	Route::get('/comments/{subreddit}/{thing}', 'ApiController@indexComment');
	
	Route::post('/vote/{id}', 'ApiController@storeVote');
	Route::delete('/vote/{id}', 'ApiController@destroyVote');

	Route::post('/save/{id}', 'ApiController@storeSave');
	Route::delete('/save/{id}', 'ApiController@destroySave');	
});