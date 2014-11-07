<?php 
namespace Readditing\Reddit;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Reddit {

	protected static $access_token;
	public static $reddit_url = 'https://oauth.reddit.com/';
 	
	public function __construct() {
		if(\Session::has('access_token')) {
			self::$access_token = \Session::get('access_token');
		}else{
			self::$access_token = '';
		}
	}

	public static function fetch($api, $params = array(), $method = 'GET') {
		$url = self::$reddit_url . '' . $api;

		$client = new Client([
		    'base_url' => self::$reddit_url,
		    'defaults' => [
		        'headers' => [
		        	'Content-type' => 'application/x-www-form-urlencoded',
		        	'Authorization' => 'bearer ' . self::$access_token,
		        	'User-Agent' => 'Readditing.com by Epick_362'
		        ]
		    ]
		]);

		$params['api_type'] = 'json';

		try {
			if($method == 'POST') {
				$response = $client->post($url, [
					'body' => $params
				]);
			}else{
				$response = $client->$method($url, [
					'query' => $params
				]);
			}

			return $response->json();
		}catch(ClientException $e){
			return \App::abort(503);
		}
	}
}