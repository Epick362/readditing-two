<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Imgur extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'imgur';

	/**
	 * Returns the authorization URL for the provider.
	 *
	 * @return  string
	 */
	public function greeting()
	{
		return $this->name;
	}
}
