<?php

class ApiController extends \BaseController {

	public function indexPost($channel = NULL, $sort = 'hot') {
		$data = Channel::indexPost($channel, Input::get('after'), $sort);

		if($data) {
			return Response::json($data);
		}

		return Response::json([['content' => \View::make('errors.nodata')->render()]]);
	}

	public function storePost() {
		$validator = Validator::make(
		    array(
		        'title' => Input::get('title'),
		        'sr' => Input::get('sr'),
		        'kind' => Input::get('kind'),
		    ),
		    array(
		        'title' => 'required',
		        'sr' => 'required|alpha_dash',
		        'kind' => 'required',
		    )
		);

		if($validator->passes()) {
			$response = Post::submit(Input::all());

			return Response::json($response);
		}

		return Response::make('Bad input.', 400);		
	}

	public function indexProfile($user, $category = 'overview') {
		if(BlacklistUsers::isBlacklisted($user)) {
			return Response::make('This user\'s profile is private.');
		}

		$data = Channel::getProfilePosts($user, $category, Input::get('after'));

		if($data) {
			return Response::json($data);
		}

		return Response::json([['content' => \View::make('errors.nodata')->render()]]);
	}

	public function indexArticle() {
		$validator = Validator::make(
		    array(
		        'url' => Input::get('url')
		    ),
		    array(
		        'url' => 'required|url'
		    )
		);

		if($validator->passes()) {
			$saved_article = Article::where('url', Input::get('url'))->first();
			if(!$saved_article) {
				Article::make(Input::get('url'));

				return Response::json(View::make('provider.other.article', ['data' => ['readability' => $return]])->render());
			}else{
				return Response::json(View::make('provider.other.article', ['data' => ['readability' => $saved_article['content']]])->render());
			}
		}

		return Response::json(null, 400);
	}

	public function indexComment($channel, $thing) {
		$data = Channel::getComments($channel, $thing);

		if($data) {
			return Response::json($data);
		}

		return Response::json(null);
	}

	public function storeComment() {
		$validator = Validator::make(
		    array(
		        'text' => Input::get('text'),
		        'thing' => Input::get('thing')
		    ),
		    array(
		        'text' => 'required',
		        'thing' => 'required|alpha_dash'
		    )
		);

		if($validator->passes()) {
			$response = Reddit::fetch('api/comment', [
				'text' => Input::get('text'),
				'thing_id' => Input::get('thing')
			], 'POST');

			if(substr(Input::get('thing'), 0, -7) == 't3') {
				Post::markAction(substr(Input::get('thing'), 3), 'commented');
			}

			Cache::tags(Session::get('user.name'))->flush();

			return Response::json($response);
		}

		return Response::make('Bad input.', 400);
	}

	public function storeVote($id) {
		$validator = Validator::make(
		    array(
		        'text' => Input::get('dir')
		    ),
		    array(
		        'text' => 'required'
		    )
		);

		if($validator->passes() && (Input::get('dir') == 1 || Input::get('dir') == -1)) {
			$response = Reddit::fetch('api/vote', [
				'dir' => Input::get('dir'),
				'id' => $id
			], 'POST'); 

			if(substr($id, 0, -7) == 't3') {
				switch (Input::get('dir')) {
					case 1:
						Post::markAction(substr($id, 3), 'likes');
						Post::unmarkAction(substr($id, 3), 'dislikes');
						break;

					case -1:
						Post::markAction(substr($id, 3), 'dislikes');
						Post::unmarkAction(substr($id, 3), 'likes');
						break;
				}
			}

			Cache::tags(Session::get('user.name'))->flush();

			return Response::make(null, 204);
		}

		return Response::make('Bad input.', 400);
	} 

	public function destroyVote($id) {
		$response = Reddit::fetch('api/vote', [
			'dir' => '0',
			'id' => $id
		], 'POST'); 

		if(substr($id, 0, -7) == 't3') {
			Post::unmarkAction(substr($id, 3), 'likes');
			Post::unmarkAction(substr($id, 3), 'dislikes');
		}

		Cache::tags(Session::get('user.name'))->flush();

		return Response::make(null, 204);	
	} 


	public function storeSave($id) {
		$response = Reddit::fetch('api/save', [
			'id' => $id
		], 'POST'); 

		if(substr($id, 0, -7) == 't3') {
			Post::markAction(substr($id, 3), 'saved');
		}

		Cache::tags(Session::get('user.name'))->flush();

		return Response::make(null, 204);
	} 

	public function destroySave($id) {
		$response = Reddit::fetch('api/unsave', [
			'id' => $id
		], 'POST'); 

		if(substr($id, 0, -7) == 't3') {
			Post::unmarkAction(substr($id, 3), 'saved');
		}

		Cache::tags(Session::get('user.name'))->flush();

		return Response::make(null, 204);	
	} 


	public function showSetting() {
		return Response::json(UsersSettings::where('user', Session::get('user.name'))->first());
	} 

	public function indexSetting($setting) {
		return Response::json(UsersSettings::where('user', Session::get('user.name'))->where('setting', $setting)->first());
	} 

	public function storeSetting($setting) {

		Cache::tags(Session::get('user.name'))->forget('settings');

		$result = UsersSettings::where('user', Session::get('user.name'))->where('setting', $setting)->first();

		if(is_null($result)) {
			$_setting = new UsersSettings;
			$_setting['user'] = Session::get('user.name');
			$_setting['setting'] = $setting;
			$_setting['value'] = 1;
			$_setting->save();

			return Response::json($_setting);
		}

		return Response::make(null, 500);
	} 

	public function destroySetting($setting) {

		Cache::tags(Session::get('user.name'))->forget('settings');

		$result = UsersSettings::where('user', Session::get('user.name'))->where('setting', $setting)->first();

		if(!is_null($result)) {
			$result->delete();

			return Response::json($result);
		}

		return Response::make(null, 500);
	}


	public function storeSubscribe() {
		if(Input::has('channel')) {
			Channel::subscribe(Input::get('channel'), 1);

			return Response::make(null, 204);
		} else if(Input::has('multi')) {
			$result = Multi::subscribe(Input::get('multi'), 1);

			if($result) {
				return Response::make(null, 204);
			}

			return Response::make(null, 500);
		}

		return Response::make(null, 400);
	} 

	public function destroySubscribe() {
		if(Input::has('channel')) {
			Channel::subscribe(Input::get('channel'), 0);

			return Response::make(null, 204);
		} else if(Input::has('multi')) {
			$result = Multi::subscribe(Input::get('multi'), 0);

			if($result) {
				return Response::make(null, 204);
			}

			return Response::make(null, 500);
		}

		return Response::make(null, 400);
	} 

	public function storeChannelToMulti($multi, $channel) {
		$result = Multi::addChannel($multi, $channel);

		if($result) {
			return Response::make(null, 204);
		}

		return Response::make(null, 400);
	}

	public function destroyChannelToMulti($multi, $channel) {
		$result = Multi::removeChannel($multi, $channel);

		if($result) {
			return Response::make(null, 204);
		}

		return Response::make(null, 400);
	}
}
