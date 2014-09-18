<?php

use Readditing\Formatter\Formatter as Formatter;

class Subreddit extends Eloquent {

	public static function getPosts( $subreddit, $after ) {
		$params = [
			'limit' => '10'
		];

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
				$post['created'] = $_post['data']['created_utc'];
				$post['ups'] = $_post['data']['ups'];
				$post['likes'] = $_post['data']['likes'];
				$post['saved'] = $_post['data']['saved'];
				$post['comments'] = $_post['data']['num_comments'];

				$post['nsfw'] = $_post['data']['over_18'];

				$result[] = $post;
			}
			return $result;
		}

		return false;
	}

	public static function getComments( $subreddit, $thing, $after = null ) {
		$comments = Reddit::fetch('r/'.$subreddit.'/comments/'.$thing.'.json', [
			'limit' => 50,
			'depth' => 3
		]);

		if(isset($comments[1]['data']['children']) && !empty($comments[1]['data']['children']) && $comments[1]['data']['children'][0]['kind'] == 't1') {
			return self::_formatComment($comments[1]);
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

	public static function getSubredditData($subreddit) {
		$data = Reddit::fetch('r/'.$subreddit.'/about.json'); 

		if($data) {
			return $data;
		}

		return false;
	}

	public static function isSubscribedToSubreddit($subreddit) {
		$mine = Reddit::fetch('reddits/mine.json'); 

		if(!empty($mine) && isset($mine['data'])) {
			foreach($mine['data']['children'] as $sub) {
				if(strtolower($sub['data']['display_name']) == strtolower($subreddit)) {
					return true;
				}
			}
		}

		return false;
	}

	private static function _formatComment($comments) {
		$result = [];

		if(!isset($comments['data']) || !isset($comments['data']['children'])) {
			return false;
		}

		foreach($comments['data']['children'] as $_comment) {
			if($_comment['kind'] == 't1') {
				$comment = [];
				$comment['id'] = $_comment['data']['id'];
				$comment['author'] = $_comment['data']['author'];
				$comment['score'] = $_comment['data']['score'];
				$comment['body'] = html_entity_decode($_comment['data']['body_html']);
				$comment['created'] = $_comment['data']['created_utc'];
				$comment['likes'] = $_comment['data']['likes'];
				$comment['saved'] = $_comment['data']['saved'];
				$comment['replies'] = self::_formatComment($_comment['data']['replies']);

				$result[] = $comment;	
			}
		}

		return $result;
	}
} 
