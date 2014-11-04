<?php

class Users extends Eloquent {

	protected $table = 'users';

    public function settings() {
        return $this->hasMany('UsersSettings', 'user', 'name');
    }

	public function multis() {
        return $this->belongsToMany('Multi', 'multi_user', 'multi_id', 'user_id');
    }
}
