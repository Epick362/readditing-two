<?php

use Readditing\Formatter\Formatter as Formatter;

class Subreddit extends Eloquent {

	public static function showPost( $subreddit, $thing ) {
		if(Session::has('user')) {
			$data = Cache::tags(Session::get('user.name'), $subreddit, $thing)->remember('comments', 2, function() use($subreddit, $thing) {
				return Reddit::fetch('r/'.$subreddit.'/comments/'.$thing.'.json');
			});
		}else{
			$data = Cache::tags($subreddit, $thing)->remember('comments', 2, function() use($subreddit, $thing) {
				return Reddit::fetch('r/'.$subreddit.'/comments/'.$thing.'.json');
			});
		}

		if($data) {
			return self::_formatPost($data[0]['data']['children'][0]);
		}

		return false;
	}

	public static function indexPost( $subreddit, $after ) {
		$params = [
			'limit' => '10'
		];

		if($after) {
			$params['after'] = $after;
		}

		if($subreddit) {
			if(Session::has('user')) {
				$posts = Cache::tags(Session::get('user.name'), $subreddit, $after)->remember('r', 2, function() use($subreddit, $params) {
					return Reddit::fetch('r/'.$subreddit.'/hot.json', $params);
				});
			}else{
				$posts = Cache::tags($subreddit, $after)->remember('r', 2, function() use($subreddit, $params) {
					return Reddit::fetch('r/'.$subreddit.'/hot.json', $params);
				});
			}
		}else{
			if(Session::has('user')) {
				$posts = Cache::tags(Session::get('user.name'), $after)->remember('r', 2, function() use($subreddit, $params) {
					return Reddit::fetch('hot.json', $params);
				});
			}else{
				$posts = Cache::tags($after)->remember('r', 2, function() use($subreddit, $params) {
					return Reddit::fetch('hot.json', $params);
				});
			}
		}

		return self::_formatPosts($posts);
	}

	public static function storePost( $input ) {
		$data = [
			'title' => $input['title'],
			'sr' => $input['sr'],
			'kind' => $input['kind'],
			'api_type' => 'json'
		];

		if(isset($input['text'])) {
			$data['text'] = $input['text'];
		}elseif(isset($input['url'])) {
			$data['url'] = $input['url'];
		}else{
			return false;
		}

		return Reddit::fetch('api/submit', $data, 'POST');
	}

	public static function getProfilePosts( $user, $category, $after ) {
		$params = [
			'limit' => '10'
		];

		if($after) {
			$params['after'] = $after;
		}

		if(Session::has('user')) {
			$posts = Cache::tags(Session::get('user.name'), $user, $category, $after)->remember('user', 2, function() use($user, $category, $params) {
				return Reddit::fetch('user/'.$user.'/'.$category.'.json', $params);
			});
		}else{
			$posts = Cache::tags($user, $category, $after)->remember('user', 2, function() use($user, $category, $params) {
				return Reddit::fetch('user/'.$user.'/'.$category.'.json', $params);
			});
		}

		return self::_formatPosts($posts);
	}

	public static function getComments( $subreddit, $thing, $after = null ) {
		if(Session::has('user')) {
			$comments = Cache::tags(Session::get('user.name'), $subreddit, $thing, 'depth4')->remember('comments', 2, function() use($subreddit, $thing) {
				return Reddit::fetch('r/'.$subreddit.'/comments/'.$thing.'.json', [
							'depth' => 4
						]);
			});
		}else{
			$comments = Cache::tags($subreddit, $thing, 'depth4')->remember('comments', 2, function() use($subreddit, $thing) {
				return Reddit::fetch('r/'.$subreddit.'/comments/'.$thing.'.json', [
							'depth' => 4
						]);
			});
		}

		if(isset($comments[1]['data']['children']) && !empty($comments[1]['data']['children']) && $comments[1]['data']['children'][0]['kind'] == 't1') {
			return self::_formatComments($comments[1]);
		}

		return false;
	}

	public static function getPopular() {
		$popular = Cache::remember('popular', 1440, function() {
			return Reddit::fetch('subreddits/popular.json'); 
		});

		if($popular) {
			return $popular;
		}

		return false;
	}

	public static function getSubscribed() {
		if(Session::has('user')) {
			$subscribed = Cache::tags(Session::get('user.name'))->remember('mine', 60, function() {
				return Reddit::fetch('subreddits/mine.json'); 
			});
			
			if($subscribed) {
				return $subscribed;
			}
		}

		return self::getPopular();
	}

	public static function getSubredditData($subreddit) {
		$data = Cache::tags($subreddit)->remember('about', 60, function() use($subreddit) {
			return Reddit::fetch('r/'.$subreddit.'/about.json'); 
		});

		if($data) {
			return $data;
		}

		return false;
	}

	public static function isSubscribedToSubreddit($subreddit) {
		$mine = Cache::tags(Session::get('user.name'))->remember('mine', 60, function() use($subreddit) {
			return Reddit::fetch('reddits/mine.json'); 
		});
		
		if(!empty($mine) && isset($mine['data'])) {
			foreach($mine['data']['children'] as $sub) {
				if(strtolower($sub['data']['display_name']) == strtolower($subreddit)) {
					return true;
				}
			}
		}

		return false;
	}

	private static function _formatPosts($posts) {
		$result = [];

		if(isset($posts['data']['children']) && !empty($posts['data']['children']) && ($posts['data']['children'][0]['kind'] == 't3' || $posts['data']['children'][0]['kind'] == 't1')) {
			foreach($posts['data']['children'] as $_post) {
				if($_post['kind'] === 't3') {
					if(!BlacklistThings::isBlacklisted($_post['data']['name']) && !BlacklistUsers::isBlacklisted($_post['data']['author'])) {
						$result[] = self::_formatPost($_post);
					}
				}
			}
			return $result;
		}

		return false;
	}

	private static function _formatPost($_post) {
		$formatter = Formatter::provider($_post);
		$post = $formatter->getPost();

		$post['title'] = htmlspecialchars_decode($post['title']);

		$post['id'] = $_post['data']['id'];
		$post['url'] = $_post['data']['url'];
		$post['subreddit'] = $_post['data']['subreddit'];
		$post['author'] = $_post['data']['author'];
		$post['created'] = $_post['data']['created_utc'];
		$post['score'] = $_post['data']['score'];
		$post['likes'] = $_post['data']['likes'];
		$post['saved'] = $_post['data']['saved'];
		$post['comments'] = $_post['data']['num_comments'];

		$post['nsfw'] = $_post['data']['over_18'];

		return $post;
	}

	private static function _formatComments($comments) {
		$result = [];

		if(!isset($comments['data']) || !isset($comments['data']['children'])) {
			return false;
		}

		foreach($comments['data']['children'] as $_comment) {
			if($_comment['kind'] == 't1') {
				if(!BlacklistUsers::isBlacklisted($_comment['data']['author']) && !BlacklistThings::isBlacklisted($_comment['data']['name'])) {
					$comment = [];
					$comment['id'] = $_comment['data']['id'];
					$comment['author'] = $_comment['data']['author'];
					$comment['score'] = $_comment['data']['score'];
					$comment['body'] = html_entity_decode($_comment['data']['body_html']);
					$comment['created'] = $_comment['data']['created_utc'];
					$comment['likes'] = $_comment['data']['likes'];
					$comment['saved'] = $_comment['data']['saved'];
					$comment['replies'] = self::_formatComments($_comment['data']['replies']);

					$result[] = $comment;	
				}
			}
		}

		return $result;
	}
} 
