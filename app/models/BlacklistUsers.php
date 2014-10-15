<?php
class BlacklistUsers extends Eloquent {

	protected $table = 'blacklist_users';

	public static function isBlacklisted($user) {
		$data = Cache::tags($user)->remember('blacklisted_users', 60, function() use($user) {
			return BlacklistUsers::where('user', $user)->first();
		});
		
		if($data) {
			return true;
		}

		return false;
	}
}