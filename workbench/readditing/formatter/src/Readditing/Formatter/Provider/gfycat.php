<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Gfycat extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'gfycat';

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
		$this->data['data']['gfycat-id'] = substr($this->data['data']['url'], strrpos($this->data['data']['url'], '/') + 1);

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.gfycat', $this->data)->render(), 
			'source' => 'gfycat.com'
		);
	}
}
