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
	public function getContent()
	{
		return $this->name;
	}
}
