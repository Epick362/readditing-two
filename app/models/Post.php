<?php

use Readditing\Formatter\Formatter as Formatter;

class Post extends Eloquent {
	public $timestamps = false;
	protected $table = 'posts';
	protected $fillable = ['name', 'url', 'title', 'author', 'channel', 'source', 'content', 'nsfw', 'comments', 'score', 'created_at', 'updated_at'];

	public function users()
    {
        return $this->belongsToMany('Users', 'post_user', 'post_id', 'user_id');
    }

    public static function show($thing, $ignore_cache = false) {
    	attempt to load from Cache
    	if(Cache::tags('post')->has($thing) && !$ignore_cache) {
    		self::markAction($thing);

    		return Cache::tags('post')->get($thing);
    	}

    	// attempt to load from DB
    	$db = self::database($thing);

    	if($db) {
    		self::markAction($db);
    		self::cache($db);
    		return $db;
    	}

    	// attempt to load via API
    	$fetch = self::fetch($thing);

    	if($fetch) {
    		self::markAction($fetch);
    		self::cache($fetch);
    		return $fetch;
    	}

    	return false;
    }

    // $thing is a reddit fullname
	private static function database($thing) {
		// load a post from DB or API
		$post = Post::where('name', $thing)->first();

		if($post) {
			if(Session::has('user.id')) {
				$actions = DB::table('post_user')->where('user_id', Session::get('user.id'))->where('post_id', $post['id'])->get();

				foreach ($actions as $action) {
					$post[$action->action] = true;
				}
			}

			return $post;
		}

		return false;
	}

	private static function fetch($thing) {
		$fetch = Reddit::fetch('comments/'.$thing.'.json');

		if($fetch) {
			$post = self::format($fetch[0]['data']['children'][0]);

			return self::store($post);
		}

		return false;
	}

	private static function cache($post) {
		return Cache::tags('post')->remember($post['name'], 5, function() use($post) {
			return $post;
		});
	}

	public static function store($post) {
		$intersect = array_intersect_key($post, array_flip(['name', 'url', 'title', 'author', 'channel', 'source', 'content', 'nsfw', 'comments', 'score', 'created_at', 'updated_at']));

		$db = Post::create($intersect);

		$intersect_actions = array_intersect_key($post, array_flip(['likes', 'saved']));

		foreach($intersect_actions as $action => $value) {
			if($value) {
				Post::markAction($db, $action);
			}
		}

		return $db;
	}

	public static function markAction($thingorpost, $action = 'read') {
		if(is_a($thingorpost, 'Post')) {
			$post = $thingorpost;
		}else{
			$post = self::show($thingorpost, TRUE);
		}

		if($post && Session::has('user.id')) {
			if(!$post->users()->where('user_id', Session::get('user.id'))->where('action', $action)->first()) {
				$post->users()->attach(Session::get('user.id'), [
					'action' => $action,
					'created_at' => date('Y-m-d H:i:s', time()),
					'updated_at' => date('Y-m-d H:i:s', time())
				]);

				return true;
			}
		}

		return false;
	}

	public static function unmarkAction($thingorpost, $action = 'read') {
		if(is_a($thingorpost, 'Post')) {
			$post = $thingorpost;
		}else{
			$post = self::show($thingorpost, TRUE);
		}

		if($post && Session::has('user.id')) {
			$exists = $post->users()->where('user_id', Session::get('user.id'))->where('action', $action)->first();
			if($exists) {
				// cannot use detach()
				// dirty HACK
				DB::table('post_user')->where('action', $action)->where('user_id', Session::get('user.id'))->limit(1)->delete();

				return true;
			}
		}

		return false;
	}

	public static function submit($input) {
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

	public static function format($_post) {
		$formatter = Formatter::provider($_post);
		$post = $formatter->getPost();

		$post['title'] = htmlspecialchars_decode($post['title']);

		$post['name'] = $_post['data']['id'];
		$post['url'] = $_post['data']['url'];
		$post['channel'] = $_post['data']['subreddit'];
		$post['author'] = $_post['data']['author'];
		$post['created_at'] = date('Y-m-d H:i:s', $_post['data']['created_utc']);
		$post['updated_at'] = date('Y-m-d H:i:s', time());
		$post['score'] = $_post['data']['score'];
		$post['likes'] = $_post['data']['likes'];
		$post['saved'] = $_post['data']['saved'];
		$post['gilded'] = $_post['data']['gilded'];
		$post['comments'] = $_post['data']['num_comments'];

		$post['nsfw'] = $_post['data']['over_18'];

		return $post;
	}
}
