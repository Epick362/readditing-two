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

	public static function test() {
		$client = new Client(['proxy' => 'tcp://80.78.38.70:3128']);

		$response = $client->get('http://api.ipify.org?format=json');

		dd($response->json());
	}

	public static function fetch($api, $params = array(), $method = 'GET') {
		$url = self::$reddit_url . '' . $api;

		$proxy = \Cache::remember('proxy', 10, function() {
			try {
				\Debugbar::startMeasure('proxyRequest', 'Time to get proxy list');

				$client = new Client();
				$response = $client->get('http://www.yasakvar.com/apiv1/', [
					'query' => [
						'type' => 'json',
						'protocol' => 'HTTPS',
						'proxyspeed' => 'FAST',
						'connectiontime' => 'FAST'
					]
				])->json();

				\Debugbar::stopMeasure('proxyRequest');

				if(isset($response['proxylist']['list-1'])) {
					$proxy = $response['proxylist']['list-1'];
					return 'tcp://'.$proxy['ip'].':'.$proxy['port'];
				}

				return null;
			} catch (\Exception $e) {
				return null;
			}
		});

		$client = new Client([
		    'base_url' => self::$reddit_url,
		    'defaults' => [
		        'headers' => [
		        	'Content-type' => 'application/x-www-form-urlencoded',
		        	'Authorization' => 'bearer ' . self::$access_token,
		        	'User-Agent' => 'Readditing by /u/Epick_362. Email: flp.hajek@gmail.com'
		        ]
		    ],
		    'proxy' => $proxy
		]);

		$params['api_type'] = 'json';

		try {
			\Debugbar::startMeasure('redditRequest', 'Time to get \''.$url.'\'');

			if($method == 'POST') {
				$response = $client->post($url, [
					'body' => $params
				]);
			}else{
				$response = $client->$method($url, [
					'query' => $params
				]);
			}

			\Debugbar::stopMeasure('redditRequest');

			return $response->json();
		}catch(\Exception $e){
			\Log::error($e);
			return false;
		}
	}
}