<?php
class Article extends Moloquent {

	protected $table = 'articles';

	public static function saveArticle($url, $data) {
		$article = new \Article;
		$article->url = $url;
		$article->content = $data['content'];
		
		return $article->save();
	}
}
