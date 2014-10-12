<?php

class UsersSettings extends Eloquent {

	protected $table = 'users_settings';

    public function user() {
        return $this->belongsTo('Users', 'name');
    }

    public static function getSettingsForSession($user) {
    	$settings = [];

    	$result = UsersSettings::where('user', $user)->get();

    	foreach($result as $setting) {
    		$settings[$setting['setting']] = $setting['value'];
    	}

    	return $settings;
    }
}
