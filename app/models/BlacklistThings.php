<?php
class BlacklistThings extends Eloquent {

	protected $table = 'blacklist_things';

	public static function isBlacklisted($thing) {
		$data = BlacklistThings::where('thing', $thing)->first();
		
		if($data) {
			return true;
		}

		return false;		
	}
}