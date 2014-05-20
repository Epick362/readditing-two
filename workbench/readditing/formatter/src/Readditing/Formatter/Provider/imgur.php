<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

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
		return array('title' => $this->data['data']['title'], 'content' => '<pre>'.print_r($this->data, true).'</pre>', 'source' => 'imgur.com');
	}
}
