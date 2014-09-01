<?php

use Readditing\Formatter\Formatter as Formatter;

class Subreddit extends Eloquent {

	public static function fetch( $subreddit, $after ) {
		$params = [];

		if($after) {
			$params['after'] = $after;
		}

		if($subreddit) {
			$posts = Cache::remember('subreddit_'.$subreddit, 10, function($subreddit, $params) {
				return Reddit::fetch('/r/'.$subreddit.'/hot.json', $params);
			});
		}else{
			$posts = Reddit::fetch('/hot.json', $params);
		}

		if(isset($posts['data']['children']) && !empty($posts['data']['children']) && $posts['data']['children'][0]['kind'] == 't3') {
			foreach($posts['data']['children'] as $_post) {

				$formatter = Formatter::provider($_post);
				$post = $formatter->getPost();

				$post['id'] = $_post['data']['id'];
				$post['url'] = $_post['data']['url'];
				$post['subreddit'] = $_post['data']['subreddit'];
				$post['author'] = $_post['data']['author'];
				$post['created'] = $_post['data']['created'];
				$post['comments'] = $_post['data']['num_comments'];

				$result[] = $post;
			}

			return $result;
		}

		return false;
	}
}
