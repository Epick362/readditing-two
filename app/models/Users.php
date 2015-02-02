<?php

class Users extends Eloquent {

	protected $table = 'users';

    public function settings() {
        return $this->hasMany('UsersSettings', 'user', 'name');
    }

    public function posts() {
        return $this->belongsToMany('Post');
    }

	public function multis() {
        return $this->belongsToMany('Multi');
    }

    public static function getAbout($username) {
		$about = Cache::tags($username)->remember('user-about', 10, function() use($username) {
			return Reddit::fetch('user/'. $username .'/about.json'); 
		});

		if($about) {
			return $about;
		}

		return false;    	
    }
}
