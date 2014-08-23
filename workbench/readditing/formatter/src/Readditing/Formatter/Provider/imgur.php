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
		return array(
			'title' => $this->data['data']['title'], 
			'content' => '<pre>'.print_r(parse_url($this->data['data']['url']), true).'</pre>', 
			'source' => 'imgur.com'
		);

		$images = array('png', 'jpg', 'jpeg', 'gif', 'png?1', 'jpg?1', 'jpeg?1', 'gif?1');
		$after_dot = substr($this->data['data']['url'], strrpos($this->data['data']['url'], '.') + 1);

		if(!in_array($after_dot, $images)) {
			$this->data['data']['imgur-id'] = substr($this->data['data']['url'], strrpos($this->data['data']['url'], '/') + 1);

			$client = new Client();
			try {
				$response = $client->get("https://api.imgur.com/3/image/".$this->data['data']['imgur-id'], [
					'headers' => ['Authorization' => 'Client-ID 45bdae835f9d9d6']
				])->json();
			}catch (ClientException $e) {
				return array(
					'title' => $this->data['data']['title'], 
					'content' => 'Sorry we couldn\'t get this image for you', 
					'source' => 'imgur.com'
				);
			}

			$this->data['data']['url'] = $response['data']['link'];
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}
}
