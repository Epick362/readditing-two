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

		if (!isset($_GET['code'])) {
			// By sending no options it'll come back here
			return $provider->authorize(array('duration' => 'permanent'));
		}else{
			try {
				$params = $provider->access($_GET['code']);

					$token = new Token_Access(array(
						'access_token' => $params->access_token
					));
					$user = $provider->get_user_info($token);

				// Here you should use this information to A) look for a user B) help a new user sign up with existing data.
				// If you store it all in a cookie and redirect to a registration page this is crazy-simple.
				echo "<pre>";
				var_dump($user);
			}

			catch (OAuth2_Exception $e) {
				echo $e;
			}
		}
	}
}