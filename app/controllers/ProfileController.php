<?php

class ProfileController extends BaseController {

	public function index($user, $category = 'overview')
	{
		$view['username'] = Session::get('user')['name'];
		$view['user'] = $user;
		$view['category'] = $category;

		if(BlacklistUsers::isBlacklisted($user)) {
			return View::make('error.blacklisted', $view);
		}

		return View::make('profile', $view);
	}
}