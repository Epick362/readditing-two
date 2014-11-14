<?php

//
//		View Composers
//

	View::composer('partials.sidebar', function($view) {
		$view->with('popular', Channel::getSubscribed());
	});

	View::composer(['channel', 'multi'], function($view) {
		$view->with('notifications', SiteNotifications::getNotifications());
	});

	View::share('username', Session::get('user.name'));