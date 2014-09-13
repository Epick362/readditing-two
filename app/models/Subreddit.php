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

	public static function getComments( $subreddit, $thing, $after = null ) {
		$comments = Reddit::fetch('r/'.$subreddit.'/comments/'.$thing.'.json');

		if(isset($comments[1]['data']['children']) && !empty($comments[1]['data']['children']) && $comments[1]['data']['children'][0]['kind'] == 't1') {
			foreach($comments[1]['data']['children'] as $_comment) {

				$comment = [];
				$comment['id'] = $_comment['data']['id'];
				$comment['author'] = $_comment['data']['author'];
				$comment['score'] = $_comment['data']['score'];
				$comment['body'] = $_comment['data']['body_html'];
				$comment['created'] = $_comment['data']['created'];
				$comment['likes'] = $_comment['data']['likes'];
				$comment['saved'] = $_comment['data']['saved'];
				$comment['replies'] = $_comment['data']['replies'];

				$result[] = $comment;
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
