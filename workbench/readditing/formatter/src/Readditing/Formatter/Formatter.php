<?php 

namespace Readditing\Formatter;

class Formatter {

	/**
	 * Create a new provider.
	 *
	 * @param   string   provider name
	 * @param   array    provider options
	 * @return  Formatter_Provider
	 */
	public static function provider($name, array $data = NULL)
	{
		$class = __NAMESPACE__ . '\\Provider\\' . ucfirst($name);

		return new $class($data);
	}
}