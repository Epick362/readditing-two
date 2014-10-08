<?php
class Article extends Eloquent {

	protected $table = 'articles';

	public static function saveArticle($url, $data, $readability = 1) {
		$article = new \Article;
		$article['url'] = $url;
		$article['content'] = $data['content'];
		$article['readability'] = 1;
		
		return $article->save();
	}
}
