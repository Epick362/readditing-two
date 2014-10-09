<?php

use Carbon\Carbon;

class SiteNotifications extends Eloquent {

	protected $table = 'site_notifications';

	public static function getNotifications() {
		$notifs = SiteNotifications::where('show_until', '>=', Carbon::now()->toDateTimeString())->get();

		return $notifs;
	}
}
