<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Vine extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'vine';

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

		if(!isset($parse_url['path'])) {
			return $this->fail();
		}

		$this->data['data']['vine-id'] = substr($parsed_url['path'], strrpos($parsed_url['path'], '/') + 1);

		return array('title' => $this->data['data']['title'], 'content' => \View::make('provider.vine', $this->data)->render(), 'source' => 'vine.co');
	}

	private function fail() {
		return array(
			'title' => $this->data['data']['title'], 
			'content' => 'Sorry we couldn\'t get this VINE for you', 
			'source' => 'vine.co'
		);
	}
}
