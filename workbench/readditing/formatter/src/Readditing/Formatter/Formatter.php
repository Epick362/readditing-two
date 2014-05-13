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

		if(class_exists($class)) {
			return new $class($data);
		}else{
			$classname = __NAMESPACE__ . '\\Provider\\OtherProvider';
			return new $classname($data);
		}
	}
}