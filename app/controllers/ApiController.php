<?php

use Readditing\Readability\Readability as Readability;

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
			$response = Channel::storePost(Input::all());

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
			$saved_article = \Article::where('url', Input::get('url'))->first();
			if(!$saved_article) {
				$readability = new Readability(Input::get('url'));
				$success = $readability->init();

				if($success) {
					$return = $readability->getContent()->innerHTML;
				}else{
					$return = '';
				}

				\Article::saveArticle(Input::get('url'), array('content' => $return), 0);

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
		$channel = Channel::getChannelData($id);

		$response = Reddit::fetch('api/subscribe', [
			'action' => 'sub',
			'sr' => 't5_'.$channel['data']['id']
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->forget('mine');

		return Response::json($response);
	} 

	public function destroySubscribe($id) {
		$channel = Channel::getChannelData($id);

		$response = Reddit::fetch('api/subscribe', [
			'action' => 'unsub',
			'sr' => 't5_'.$channel['data']['id']
		], 'POST'); 

		Cache::tags(Session::get('user.name'))->forget('mine');

		return Response::json($response);		
	} 
}
