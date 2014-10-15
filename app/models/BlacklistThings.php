<?php
class BlacklistThings extends Eloquent {

	protected $table = 'blacklist_things';

	public static function isBlacklisted($thing) {
		$blacklist = Cache::rememberForever('blacklisted_things', function() use($thing) {
			return BlacklistThings::get();
		});

		foreach ($blacklist as $value) {
			if(isset($value['thing']) && $value['thing'] === $thing) {
				return true;
			}
		}

		return false;		
	}
}