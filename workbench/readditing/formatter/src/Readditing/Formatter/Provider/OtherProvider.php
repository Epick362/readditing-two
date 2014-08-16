<?php

namespace Readditing\Formatter\Provider;

use Readditing\Formatter\Provider;
use Readditing\Readability\Readability as Readability;

class OtherProvider extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'OtherProvider';

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

		$images = array('png', 'jpg', 'jpeg', 'gif');
		$after_dot = substr($this->data['data']['url'], strrpos($this->data['data']['url'], '.') + 1);

		if(in_array($after_dot, $images)) {
			return array(
				'title' => $this->data['data']['title'], 
				'content' => \View::make('provider.other.image', $this->data)->render(), 
				'source' => preg_replace('/^www\./i', '', $purl['host'])
			);
		}

		$saved_article = \Article::where('url', $this->data['data']['url'])->first();
		if(!$saved_article) {
			$readability = new Readability($this->data['data']['url']);
			$readability->init();

			if($readability->getContent()) {
				$this->data['data']['readability'] = $readability->getContent()->innerHTML;

				\Article::saveArticle($this->data['data']['url'], array('content' => $this->data['data']['readability']));
			}else{
				$this->data['data']['readability'] = '';
			}
		}else{
			$article = $saved_article;

			$this->data['data']['readability'] = $article->content;
		}

		return array(
			'title' => $this->data['data']['title'], 
			'content' => \View::make('provider.other.article', $this->data)->render(), 
			'source' => preg_replace('/^www\./i', '', $purl['host'])
		);
	}
}