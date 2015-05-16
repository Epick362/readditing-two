<?php

use Readditing\Formatter\Formatter as Formatter;

class Channel extends Eloquent {

	public static function indexPost( $channel, $after, $sort = 'hot' ) {
		$params = [
			'limit' => '10'
		];

		$sorting = ['hot', 'rising', 'new', 'top', 'controversial'];
		if(!in_array($sort, $sorting)) {
			$sort = 'hot';
		}

		if($after && $after != 't3_undefined') {
			$params['after'] = $after;
		}

		if($channel) {
			if(Session::has('user')) {
				$posts = Cache::tags(Session::get('user.name'), $channel, $after, $sort)->remember('r', 5, function() use($channel, $params, $sort) {
					return Reddit::fetch('r/'.$channel.'/'.$sort.'.json', $params);
				});
			}else{
				$posts = Cache::tags($channel, $after, $sort)->remember('r', 5, function() use($channel, $params, $sort) {
					return Reddit::fetch('r/'.$channel.'/'.$sort.'.json', $params);
				});
			}
		}else{
			if(Session::has('user')) {
				$posts = Cache::tags(Session::get('user.name'), $after, $sort)->remember('r', 5, function() use($channel, $params, $sort) {
					return Reddit::fetch($sort.'.json', $params);
				});
			}else{
				$posts = Cache::tags($after, $sort)->remember('r', 2, function() use($channel, $params, $sort) {
					return Reddit::fetch($sort.'.json', $params);
				});
			}
		}

		return self::_formatPosts($posts);
	}

	public static function getProfilePosts( $user, $category, $after ) {
		$params = [
			'limit' => '10'
		];

		if($after && $after != 't3_undefined') {
			$params['after'] = $after;
		}

		if(Session::has('user')) {
			$posts = Cache::tags(Session::get('user.name'), $user, $category, $after)->remember('user', 5, function() use($user, $category, $params) {
				return Reddit::fetch('user/'.$user.'/'.$category.'.json', $params);
			});
		}else{
			$posts = Cache::tags($user, $category, $after)->remember('user', 5, function() use($user, $category, $params) {
				return Reddit::fetch('user/'.$user.'/'.$category.'.json', $params);
			});
		}

		return self::_formatPosts($posts);
	}

	public static function getComments( $channel, $thing, $after = null ) {
		if(Session::has('user')) {
			$comments = Cache::tags(Session::get('user.name'), $channel, $thing, 'depth4')->remember('comments', 5, function() use($channel, $thing) {
				return Reddit::fetch('r/'.$channel.'/comments/'.$thing.'.json', [
							'depth' => 4
						]);
			});
		}else{
			$comments = Cache::tags($channel, $thing, 'depth4')->remember('comments', 5, function() use($channel, $thing) {
				return Reddit::fetch('r/'.$channel.'/comments/'.$thing.'.json', [
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

	public static function getChannelData($channel) {
		if(strpos($channel, '+') !== false || strpos($channel, ' ') !== false) {
			return false;
		}

		$data = Cache::tags($channel)->remember('about', 60, function() use($channel) {
			return Reddit::fetch('r/'.$channel.'/about.json'); 
		});

		if($data) {
			return $data['data'];
		}

		return false;
	}

	public static function isSubscribedToChannel($channel) {
		$mine = Cache::tags(Session::get('user.name'))->remember('mine', 60, function() use($channel) {
			return Reddit::fetch('reddits/mine.json'); 
		});
		
		if(!empty($mine) && isset($mine['data'])) {
			foreach($mine['data']['children'] as $sub) {
				if(strtolower($sub['data']['display_name']) == strtolower($channel)) {
					return true;
				}
			}
		}

		return false;
	}

	/*
		Subscribe to channel.

		$ch - name of the channel
		$dir - 0 = unsubscribe
			   1 = subscribe
	*/
	public static function subscribe($ch, $dir) {
		$channel = Channel::getChannelData(Input::get('channel'));

		$response = Reddit::fetch('api/subscribe', [
			'action' => ($dir ? 'sub' : 'unsub'),
			'sr' => 't5_'.$channel['id']
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->forget('mine');

		return;
	}

	public static function getFeatured() {
		return Cache::remember('top', 300, function() {
			$featured = [];

			while (count($featured) <= 10) {
				$response = Reddit::fetch('r/all.json?sort=top&t=day');
				
				$posts = self::_formatPosts($response);

				if($posts) {
					foreach($posts as $post) {
						if(isset($post['image']) && !$post['nsfw']) {
							$featured[] = $post;
						}
					}
				}
			}

			return $featured; 
		});
	}

	public static function getAnnouncement() {
		return Cache::remember('announcement', 1440, function() {
			$announcement = [];

			$response = Reddit::fetch('r/readditingcom/.json');

			$posts = self::_formatPosts($response);

			if($posts) {
				foreach($posts as $post) {
					if($post['author'] == 'Epick_362' && strtotime($post['created_at']) >= time() - 60*60*24*2) {
						$announcement = $post;
						break;
					}
				}
			}

			return $announcement;
		});
	}

	private static function _formatPosts($posts) {
		$result = [];

		if(isset($posts['data']['children']) && !empty($posts['data']['children']) && ($posts['data']['children'][0]['kind'] == 't3' || $posts['data']['children'][0]['kind'] == 't1')) {
			foreach($posts['data']['children'] as $_post) {
				if($_post['kind'] === 't3') {
					if(!BlacklistThings::isBlacklisted($_post['data']['name']) && !BlacklistUsers::isBlacklisted($_post['data']['author'])) {
						$_cache[0]['data']['children'][0] = $_post;
						if(Session::get('user.name')) {
							$data = Cache::tags(Session::get('user.name'), $_post['data']['subreddit'], $_post['data']['id'])->remember('comments', 1, function() use($_cache) {
								return $_cache;
							});
						}else{
							$data = Cache::tags($_post['data']['subreddit'], $_post['data']['id'])->remember('comments', 1, function() use($_cache) {
								return $_cache;
							});
						}
												
						$fpost = Post::format($_post);

						if($fpost) {
							$result[] = $fpost;
						}
					}
				}
			}
			return $result;
		}

		return false;
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
					$comment['gilded'] = $_comment['data']['gilded'];
					$comment['replies'] = self::_formatComments($_comment['data']['replies']);

					$result[] = $comment;	
				}
			}
		}

		return $result;
	}
} 
