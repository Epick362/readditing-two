<?php

class ProfileController extends BaseController {

	public function overview($user)
	{
		$view['username'] = Session::get('user')['name'];
		$view['user'] = $user;

		return View::make('profile', $view);
	}
}