<?php

class ApiController extends \BaseController {

	public function indexPost($subreddit = NULL) {
		$data = Subreddit::indexPost($subreddit, Input::get('after'));

		dd($data);

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
			$response = Subreddit::storePost(Input::all());

			return Response::json($response);
		}

		return Response::make('Bad input.', 400);		
	}

	public function indexProfile($user, $category = 'overview') {
		if(BlacklistUsers::isBlacklisted($user)) {
			return Response::make('This user\'s profile is private.');
		}

		$data = Subreddit::getProfilePosts($user, $category, Input::get('after'));

		if($data) {
			return Response::json($data);
		}

		return Response::json([['content' => \View::make('errors.nodata')->render()]]);
	}

	public function indexComment($subreddit, $thing) {
		$data = Subreddit::getComments($subreddit, $thing);

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

			return Response::json($response);
		}

		return Response::make('Bad input.', 400);
	}

	public function storeVote($id) {
		$response = Reddit::fetch('api/vote', [
			'dir' => '1',
			'id' => $id
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->flush();

		return Response::json($response);
	} 

	public function destroyVote($id) {
		$response = Reddit::fetch('api/vote', [
			'dir' => '0',
			'id' => $id
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->flush();

		return Response::json($response);		
	} 


	public function storeSave($id) {
		$response = Reddit::fetch('api/save', [
			'id' => $id
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->flush();

		return Response::json($response);
	} 

	public function destroySave($id) {
		$response = Reddit::fetch('api/unsave', [
			'id' => $id
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->flush();

		return Response::json($response);		
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

		return Response::json(null);
	} 

	public function destroySetting($setting) {

		Cache::tags(Session::get('user.name'))->forget('settings');

		$result = UsersSettings::where('user', Session::get('user.name'))->where('setting', $setting)->first();

		if(!is_null($result)) {
			$result->delete();

			return Response::json($result);
		}

		return Response::json(null);
	}


	public function storeSubscribe($id) {
		$subreddit = Subreddit::getSubredditData($id);

		$response = Reddit::fetch('api/subscribe', [
			'action' => 'sub',
			'sr' => 't5_'.$subreddit['data']['id']
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->forget('mine');

		return Response::json($response);
	} 

	public function destroySubscribe($id) {
		$subreddit = Subreddit::getSubredditData($id);

		$response = Reddit::fetch('api/subscribe', [
			'action' => 'unsub',
			'sr' => 't5_'.$subreddit['data']['id']
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->forget('mine');

		return Response::json($response);		
	} 
}
