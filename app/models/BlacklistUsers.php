<?php
class BlacklistUsers extends Eloquent {

	protected $table = 'blacklist_users';

	public static function isBlacklisted($user) {
		$data = Cache::tags($user)->rememberForever('blacklisted_users', function() use($user) {
			return BlacklistUsers::where('user', $user)->first();
		});
		
		if($data) {
			return true;
		}

		return false;
	}
}