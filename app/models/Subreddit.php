<?php

use Readditing\Formatter\Formatter as Formatter;

class Subreddit extends Moloquent {

	public static function fetch( $subreddit, $formatted = true ) {
		if($subreddit) {
			$posts = Reddit::fetch('/r/'.$subreddit.'/hot.json');
		}else{
			$posts = Reddit::fetch('/hot.json');
		}

		if(isset($posts['data']['children']) && !empty($posts['data']['children'])) {
			foreach($posts['data']['children'] as $_post) {

				if($formatted) {
					$formatter = Formatter::provider($_post);
					$post = $formatter->getPost();
				}else{
					$post['title'] = $_post['data']['title'];
					$post['content'] = $_post['data']['selftext_html'];
				}
				
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
