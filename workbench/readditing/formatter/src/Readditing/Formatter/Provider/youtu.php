<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Youtu extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'youtu';

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

		$this->data['data']['youtube-id'] = substr($parse_url['path'], 1);

		return array('title' => $this->data['data']['title'], 'content' => \View::make('provider.youtube', $this->data)->render(), 'source' => 'youtube.com');
	}
}
