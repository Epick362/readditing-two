<?php

class FrontpageController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function subreddit($subreddit = 'home')
	{
		return View::make('frontpage')->with('subreddit', $subreddit);
	}

	public function auth() {
		return View::make('frontpage')->with('subreddit', 'Logged In');
	}
}