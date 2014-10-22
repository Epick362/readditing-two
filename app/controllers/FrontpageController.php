<?php

use Readditing\Readability\Readability as Readability;

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

	public function channel($channel = 'funny+adviceanimals+memes+videos+pics', $after = NULL)
	{
		$view = array();
		$view['channel'] = $channel;
		$view['username'] = Session::get('user.name');
		$view['notifications'] = SiteNotifications::getNotifications();
		
		if($channel) {
			$view['channelData'] = Channel::getChannelData($channel);
			$view['subscribed'] = Channel::isSubscribedToChannel($channel);
		}

		$view['popular'] = Channel::getSubscribed();

		return View::make('frontpage', $view);
	}

	public function post($channel, $thing) {
		$view = array();
		$view['channel'] = $channel;
		$view['username'] = Session::get('user')['name'];
		$view['popular'] = Channel::getSubscribed();

		$view['post'] = Channel::showPost($channel, $thing);

		if(!$view['post'] || BlacklistThings::isBlacklisted('t3_'.$view['post']['id'])) {
			return Redirect::to('404');
		}

		if(BlacklistUsers::isBlacklisted($view['post']['author'])) {
			return View::make('errors.blacklisted', ['user' => $view['post']['author']]);
		}

		return View::make('post', $view);
	}

	public function submit() {
		$view = array();
		$view['username'] = Session::get('user')['name'];
		$view['channel'] = Input::get('channel');

		return View::make('submit', $view);
	}
}