<?php 

namespace Readditing\Formatter;

abstract class Provider {

	/**
	 * Overloads default class properties from the options.
	 *
	 *
	 * @param   array   post data
	 * @return  void
	 */
	public function __construct(array $data = array())
	{
		if ( ! $this->name)
		{
			// Attempt to guess the name from the class name
			$this->name = strtolower(get_class($this));
		}

	}

	abstract public function getContent();

	/**
	 * Return the value of any protected class variable.
	 *
	 *     // Get the provider signature
	 *     $signature = $provider->signature;
	 *
	 * @param   string  variable name
	 * @return  mixed
	 */
	public function __get($key)
	{
		return $this->$key;
	}
}