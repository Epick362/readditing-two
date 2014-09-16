<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Youtube extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'youtube';

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
		$parse_url = parse_url($this->data['data']['url']);

		if(!isset($parse_url['query'])) {
			return $this->fail();
		}

		$this->data['data']['youtube-id'] = strtok(substr($parse_url['query'], strpos($parse_url['query'], "=") + 1), '&');

		return array('title' => $this->data['data']['title'], 'content' => \View::make('provider.youtube', $this->data)->render(), 'source' => 'youtube.com');
	}

	private function fail() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => 'Sorry we couldn\'t get this video for you', 
			'source' => 'youtube.com'
		);
	}
}
