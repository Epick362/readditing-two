<?php

//
//		View Composers
//

	View::composer('partials.sidebar', function($view) {
		$view->with('popular', Channel::getSubscribed());
		$view->with('featured', Channel::getFeatured());
	});

	View::composer(['channel', 'multi'], function($view) {
		$view->with('notifications', SiteNotifications::getNotifications());
		$view->with('announcement', Channel::getAnnouncement());
	});

	View::share('username', Session::get('user.name'));