<?php

use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

class AuthController extends Controller {

	public function auth()
	{
		$provider = OAuth2::provider('reddit', array(
			'id' => '7Ojt4UvaXdlfIg',
			'secret' => 'diuIcaD4ejI0ZUlQXbDqRTxBRjA',
		));

		if(Cookie::get('refresh_token')) {
			try {
				$params = $provider->access(Cookie::get('refresh_token'), array('grant_type' => 'refresh_token'));

				$this->authorize($params, $provider);
			}

			catch (OAuth2_Exception $e) {
				echo 'Something went wrong<br />';
				return;
			}
		}else if (!isset($_GET['code'])) {
			// By sending no options it'll come back here
			return $provider->authorize();
		}else{
			try {
				$params = $provider->access($_GET['code']);

				$this->authorize($params, $provider);
			}

			catch (OAuth2_Exception $e) {
				echo 'Something went wrong<br />';
				return;
			}
		}

		return Redirect::to(Session::pull('intended', '/'));
	}

	private function authorize($params, $provider) {
		$token = new Token_Access(array(
			'access_token' => $params->access_token
		));
			
		$user = $provider->get_user_info($token);

		// Just dump all of the user info into session
		/*
			array(10) {
			  ["name"]=>
			  string(9) "Epick_362"
			  ["created"]=>
			  float(1375747259)
			  ["created_utc"]=>
			  float(1375743659)
			  ["link_karma"]=>
			  int(12)
			  ["comment_karma"]=>
			  int(37)
			  ["over_18"]=>
			  bool(true)
			  ["is_gold"]=>
			  bool(false)
			  ["is_mod"]=>
			  bool(false)
			  ["has_verified_email"]=>
			  bool(false)
			  ["id"]=>
			  string(5) "cn3jt"
			}
		*/
		Session::put('user', $user);
		Session::put('access_token', $params->access_token);
		Cookie::queue('token_generated', time(), 60 * 24 * 30);

		// Set the refresh token cookies
		if(isset($params->refresh_token) && $params->refresh_token != NULL) {
			Cookie::queue('refresh_token', $params->refresh_token, 60 * 24 * 30);	
		}	
	}
}