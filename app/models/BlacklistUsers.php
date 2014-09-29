<?php
class BlacklistUsers extends Eloquent {

	protected $table = 'blacklist_users';

	public static function isBlacklisted($user) {
		$data = BlacklistUsers::where('user', $user)->first();
		
		if($data) {
			return true;
		}

		return false;
	}
}