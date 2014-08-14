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
	public static function provider(array $data = NULL)
	{
		$parts = parse_url($data['data']['url']);

		$host = str_replace('www.', '', $parts['host']);
		$matches = array();
		preg_match('/(.*?)((\.co)?.[a-z]{2,4})$/i', $host, $matches);
		if(strchr($matches[1], '.')) {
			$_url = substr(strrchr($matches[1], '.'), 1);
		}else{
			$_url = $matches[1];
		}

		$class = __NAMESPACE__ . '\\Provider\\' . ucfirst($_url);

		if(class_exists($class)) {
			return new $class($data);
		}else{
			$classname = __NAMESPACE__ . '\\Provider\\OtherProvider';
			return new $classname($data);
		}
	}
}