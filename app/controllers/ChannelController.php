<?php

use Readditing\Readability\Readability as Readability;

class ChannelController extends BaseController {

	public function channel($channel = NULL, $sort = NULL)
	{
		$view['channel'] = $channel;
		$view['sort'] = $sort;
		
		if($channel) {
			$view['channelData'] = Channel::getChannelData($channel);
			$view['subscribed'] = Channel::isSubscribedToChannel($channel);
		}

		return View::make('channel', $view);
	}

	public function multi($name) {
		$multi = Multi::where('name', $name)->first();

		if(!$multi) {
			return App::abort(404);
		}

		$view = array();
		$view['channel'] = implode($multi['channels'], '+');
		$view['subscribers'] = Multi::getSubscribers($name);
		$view['multi'] = $multi['name'];

		return View::make('multi', $view);		
	}

	public function post($channel, $thing) {
		$view['channel'] = $channel;

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
		$view['channel'] = Input::get('channel');

		return View::make('submit', $view);
	}
}