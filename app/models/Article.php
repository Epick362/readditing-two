<?php

use Readditing\Readability\Readability as Readability;

class Article extends Eloquent {

	protected $table = 'articles';

	public static function saveArticle($url, $data, $readability = 1) {
		$article = new \Article;
		$article['url'] = $url;
		$article['content'] = $data['content'];
		$article['readability'] = 1;
		
		return $article->save();
	}

	public static function make($url) {
		$readability = new Readability(Input::get('url'));
		$success = $readability->init();

		if($success) {
			$return = $readability->getContent()->innerHTML;
		}else{
			$return = '';
		}

		Article::saveArticle(Input::get('url'), array('content' => $return), 0);

		return $return;
	}
}
