<?php
class Article extends Eloquent {

	protected $table = 'articles';

	public static function saveArticle($url, $data) {
		$article = new \Article;
		$article->url = $url;
		$article->content = $data['content'];
		
		return $article->save();
	}
}
