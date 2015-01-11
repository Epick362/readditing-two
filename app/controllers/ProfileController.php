<?php

class ProfileController extends BaseController {

	public function index($user, $category = 'overview')
	{
		$view['user'] = $user;
		$view['user_in_db'] = Users::where('name', $user)->first();
		$view['category'] = $category;

		if(BlacklistUsers::isBlacklisted($user) && $user !== Session::get('user.name')) {
			return View::make('errors.blacklisted', $view);
		}

		return View::make('profile', $view);
	}

	public function unlist() {
		if(!BlacklistUsers::where('user', Session::get('user.name'))->first()) {
			$user = new \BlacklistUsers;
			$user['user'] = Session::get('user.name');
			$user->save();

			Cache::forget('blacklisted_users');

			Session::flash('message', '<i class="fa fa-check"></i> Succesfully unlisted from Readditing.');
		}else{
			Session::flash('message', 'You are already unlisted.');
		}

		return Redirect::to('/');
	}
}