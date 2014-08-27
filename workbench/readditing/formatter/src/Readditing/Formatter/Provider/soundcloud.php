<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;

class Soundcloud extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'soundcloud';

	public function __construct($data) {
		$this->data = $data;
	}
	/**
	 * This is where the magic happens
	 *
	 * @return  Array
	 */
	public function getPost()
	{
		try {
			$client = new Client();
			$response = $client->get("http://soundcloud.com/oembed?format=json&url=".urlencode($this->data['data']['url']))->json();
		}catch (\Exception $e) {
			return $this->fail();
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => $response['html'], 
			'source' => 'soundcloud.com'
		);
	}

	private function fail() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => 'Sorry we couldn\'t get this music for you', 
			'source' => 'soundcloud.com'
		);
	}
}
