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
	public function getContent()
	{
		$saved_article = \Article::where('url', $this->data['data']['url'])->first();
		if(!$saved_article) {
			$readability = new Readability($this->data['data']['url']);
			$readability->init();

			$result['title'] = $readability->getTitle()->innerHTML;
			$result['content'] = $readability->getContent()->innerHTML;

			$article = new \Article;
			$article->url = $link;
			$article->title = $readability->getTitle()->innerHTML;
			$article->content = $readability->getContent()->innerHTML;
			$article->save();
		}else{
			$article = $saved_article;

			$result['title'] = $article->title;
			$result['content'] = $article->content;
			$result['extra'] = 'cached';
		}

		return $result;
	}
}
