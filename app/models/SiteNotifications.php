<?php

use Carbon\Carbon;

class SiteNotifications extends Eloquent {

	protected $table = 'site_notifications';

	public static function getNotifications() {
		$notifs = Cache::remember('site_notifications', 60, function() {
			return SiteNotifications::where('show_until', '>=', Carbon::now()->toDateTimeString())->get();
		});

		return $notifs;
	}
}
