<?php
namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;


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
		$this->data['data']['imgur-id'] = substr($this->data['data']['url'], strrpos($this->data['data']['url'], '/') + 1);

		$client = new Client();
		$response = $client->get("https://api.imgur.com/3/image/".$this->data['data']['imgur-id'], [
			'headers' => ['Authorization' => 'Client-ID 45bdae835f9d9d6']
		])->json();

		$this->data['data']['url'] = $response['data']['link'];

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'imgur.com'
		);
	}
}
