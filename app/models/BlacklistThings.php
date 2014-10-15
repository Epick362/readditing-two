<?php
class BlacklistThings extends Eloquent {

	protected $table = 'blacklist_things';

	public static function isBlacklisted($thing) {
		$data = Cache::tags($thing)->remember('blacklisted_things', 60, function() use($thing) {
			return BlacklistThings::where('thing', $thing)->first();
		});
		
		if($data) {
			return true;
		}

		return false;		
	}
}