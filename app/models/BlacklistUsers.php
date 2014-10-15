<?php
class BlacklistUsers extends Eloquent {

	protected $table = 'blacklist_users';

	public static function isBlacklisted($user) {
		$blacklist = Cache::rememberForever('blacklisted_users', function() use($user) {
			return BlacklistUsers::get();
		});

		foreach ($blacklist as $value) {
			if(isset($value['user']) && $value['user'] === $user) {
				return true;
			}
		}

		return false;		
	}
}