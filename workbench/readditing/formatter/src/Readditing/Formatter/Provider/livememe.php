<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Livememe extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'livememe';
	public $livememe_url = 'http://i.lvme.me/';

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
		$purl = parse_url($this->data['data']['url']);

		$this->data['data']['url'] = $this->livememe_url . substr($purl['path'], 1) . '.jpg';

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.image', $this->data)->render(), 
			'source' => 'livememe.com'
		);
	}
}