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
		$readability = new Readditing\Readability\Readability(['url' => 'http://www.sciencedaily.com/releases/2014/04/140425104714.htm']);

		$readability->init();

		print_r($readability->getContent()->innerHTML);

		return View::make('frontpage')->with('subreddit', $subreddit);
	}

	public function auth() {
		return View::make('frontpage')->with('subreddit', 'Logged In');
	}
}