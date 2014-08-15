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

		$purl = parse_url($this->data['data']['url']);

		return array('title' => $this->data['data']['title'], 'content' => \View::make('provider.other', $this->data)->render(), 'source' => preg_replace('/^www\./i', '', $purl['host']));
	}
}
