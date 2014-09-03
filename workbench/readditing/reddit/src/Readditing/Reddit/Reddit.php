<?php 
namespace Readditing\Reddit;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;

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

		$post = array();

		if($method == 'POST') {
			$post = $params;
		}else{
			$postdata = http_build_query($params);
			$url .= '?'.$postdata;
		}

		$client = new Client([
		    'base_url' => self::$reddit_url,
		    'defaults' => [
		        'headers' => [
		        	'Content-type' => 'application/x-www-form-urlencoded',
		        	'Authorization' => 'bearer ' . self::$access_token,
		        	'User-Agent' => 'Readditing.com by Epick_362'
		        ]
		    ]
		], $post);

		$request = $client->createRequest($method, $url);


		return $client->send($request)->json();
	}
}