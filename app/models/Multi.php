<?php

class Multi extends Eloquent {

	protected $table = 'multis';

	public function users()
    {
        return $this->belongsToMany('Users');
    }

	public function getChannelsAttribute($value) {
		return unserialize($value);
	}

	public function setChannelsAttribute($value) {
		$this->attributes['channels'] = serialize($value);
	}

	public static function addChannel($name, $channel) {
		$multi = Multi::where('name', $name)->first();

		if($multi && !array_search($channel, $multi['channels'])) {
			$temp = $multi['channels'];
			array_push($temp, $channel);

			$multi['channels'] = $temp;

			$multi->save();

			return true;
		}

		return false;
	}

	public static function removeChannel($name, $channel) {
		$multi = Multi::where('name', $name)->first();

		if($multi && ($key = array_search($channel, $multi['channels'])) !== false) {
			$temp = $multi['channels'];

			unset($temp[$key]);

			$multi['channels'] = $temp;

			$multi->save();

			return true;
		}

		return false;
	}

	public static function getSubscribers($name) {
		$multi = Multi::where('name', $name)->first();

		return count($multi->users()->get());
	}

	public static function isSubscribed($name) {
		$multi = Multi::where('name', $name)->first();

		$result = $multi->users()->find(Session::get('user.id'));

		if($result) {
			return true;
		}

		return false;
	}

	public static function subscribe($name, $dir) {
		$multi = Multi::where('name', $name)->first();

		if($multi) {
			switch($dir) {
				case 1: 
					if(!$multi->users()->find(Session::get('user.id'))) {
						$multi->users()->attach(Session::get('user.id'));
					}
					break;

				case 0: 
					$multi->users()->detach(Session::get('user.id'));
					break;
			}

			return true;
		}

		return false;
	}
}
