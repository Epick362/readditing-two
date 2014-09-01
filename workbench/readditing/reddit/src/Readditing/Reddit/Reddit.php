<?php namespace Readditing\Reddit;
 
class Reddit {

	protected static $access_token;
	public static $reddit_url = 'https://oauth.reddit.com';
 	
	public function __construct() {
		if(\Session::has('access_token')) {
			self::$access_token = \Session::get('access_token');
		}else{
			self::$access_token = '';
		}
	}

	public static function fetch($api, $params = array(), $method = 'GET') {
		$url = self::$reddit_url . '' . $api;

		$postdata = http_build_query($params);

		$url .= '?'.$postdata;

		$response = \Cache::remember(urlencode($url), 5, function() use($method) {
			$opts = array(
				'http' => array(
					'method'  => $method,
					'header'  => array('Content-type: application/x-www-form-urlencoded',
										'Authorization: bearer ' . self::$access_token,
										'User-Agent: Readditing.com by Epick_362')
				)
			);
			$_default_opts = stream_context_get_params(stream_context_get_default());
			$context = stream_context_create(array_merge_recursive($_default_opts['options'], $opts));

			return json_decode(@file_get_contents($url, false, $context), true);
		});

		return $response;
	}
}