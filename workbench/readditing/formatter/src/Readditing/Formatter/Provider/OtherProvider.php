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
		$saved_article = \Article::where('url', $this->data['data']['url'])->first();
		if(!$saved_article) {
			$readability = new Readability($this->data['data']['url']);
			$readability->init();

			$result['title'] = $readability->getTitle()->innerHTML;
			$result['content'] = $readability->getContent()->innerHTML;

			$article = new \Article;
			$article->url = $this->data['data']['url'];
			$article->title = $readability->getTitle()->innerHTML;
			$article->content = $readability->getContent()->innerHTML;
			$article->save();
		}else{
			$article = $saved_article;

			$result['title'] = $article->title;
			$result['content'] = $article->content;
			$result['extra'] = 'cached';
		}

		$purl = parse_url($this->data['data']['url']);
		$result['source'] = preg_replace('/^www\./i', '', $purl['host']);

		return $result;
	}
}
