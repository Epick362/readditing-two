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
	*/

	public function subreddit($subreddit = NULL, $after = NULL)
	{
		$view = array();
		$view['subreddit'] = $subreddit;
		$view['username'] = Session::get('user')['name'];

		if($subreddit) {
			$view['subscribed'] = Subreddit::isSubscribedToSubreddit($subreddit);
		}

		$view['popular'] = Subreddit::getPopular();

		return View::make('frontpage', $view);
	}

	public function post($subreddit, $thing) {
		$view = array();
		$view['subreddit'] = $subreddit;
		$view['username'] = Session::get('user')['name'];
		$view['popular'] = Subreddit::getPopular();

		$view['post'] = Subreddit::showPost($subreddit, $thing);

		if($view['post']) {
			return View::make('errors.404');
		}

		if(BlacklistUsers::isBlacklisted($view['post']['author'])) {
			return View::make('errors.blacklisted', ['user' => $view['post']['author']]);
		}

		return View::make('post', $view);
	}

	public function submit() {
		$view = array();
		$view['username'] = Session::get('user')['name'];
		$view['subreddit'] = Input::get('subreddit');

		return View::make('submit', $view);
	}
}