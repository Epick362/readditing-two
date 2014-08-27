<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;

class Reddit extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'reddit';

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
		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.reddit', $this->data)->render(), 
			'source' => 'self.'.$this->data['data']['subreddit']
		);
	}
}
