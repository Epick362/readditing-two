<?php
namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;


class Imgur extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'imgur';

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
		$parsed_url = parse_url($this->data['data']['url']);

		$images = array('png', 'jpg', 'jpeg', 'gif');
		$after_dot = substr($parsed_url['path'], strrpos($parsed_url['path'], '.') + 1);

		if(!in_array($after_dot, $images)) {
			$parts = explode("/", $parsed_url['path']);

			if($parts[1] == "a") {
				return $this->getAlbum($parts[1]);
			}else{
				return $this->getImage($parts[0]);
			}
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	public function getAlbum() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.imgur', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	public function getImage($id) {
		try {
			$client = new Client();
			$response = $client->get("https://api.imgur.com/3/image/".$id, [
				'headers' => ['Authorization' => 'Client-ID 45bdae835f9d9d6']
			])->json();
return array(
			'title' => $this->data['data']['title'], 
			'content' => '<pre>'.$response.'</pre>', 
			'source' => 'imgur.com'
		);
		}catch (ClientException $e) {
			return $this->fail();
		}

		$this->data['data']['url'] = $response['data']['link'];

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}

	private function fail() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => 'Sorry we couldn\'t get this image for you', 
			'source' => 'imgur.com'
		);
	}
}
