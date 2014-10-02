<?php

class Users extends Eloquent {

	protected $table = 'users';

    public function settings() {
        return $this->hasMany('UsersSettings', 'user', 'name');
    }
}
