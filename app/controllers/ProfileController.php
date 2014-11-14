<?php

class ProfileController extends BaseController {

	public function index($user, $category = 'overview')
	{
		$view['user'] = $user;
		$view['user_in_db'] = Users::where('name', $user)->first();
		$view['category'] = $category;

		if(BlacklistUsers::isBlacklisted($user)) {
			return View::make('errors.blacklisted', $view);
		}

		return View::make('profile', $view);
	}
}