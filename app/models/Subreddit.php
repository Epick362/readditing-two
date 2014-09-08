<?php

use Readditing\Formatter\Formatter as Formatter;

class Subreddit extends Eloquent {

	public static function getPosts( $subreddit, $after ) {
		$params = [];

		if($after) {
			$params['after'] = $after;
		}

		if($subreddit) {
			$posts = Reddit::fetch('r/'.$subreddit.'/hot.json', $params);
		}else{
			$posts = Reddit::fetch('hot.json', $params);
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
				$post['ups'] = $_post['data']['ups'];
				$post['likes'] = $_post['data']['likes'];
				$post['saved'] = $_post['data']['saved'];
				$post['comments'] = $_post['data']['num_comments'];

				$result[] = $post;
			}
			return $result;
		}

		return false;
	}

	public static function getPopular() {
		$popular = Reddit::fetch('subreddits/popular.json');

		if($popular) {
			return $popular;
		}

		return false;
	}
}
