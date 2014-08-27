<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Youtube extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'youtube';

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
		dd(parse_url($this->data['data']['url']));

		$this->data['data']['youtube-id'] = '';

		return array('title' => $this->data['data']['title'], 'content' => \View::make('provider.youtube', $this->data)->render(), 'source' => 'youtube.com');
	}
}
