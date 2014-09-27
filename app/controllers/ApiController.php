<?php

class ApiController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function indexPost($subreddit = NULL) {
		$data = Subreddit::getPosts($subreddit, Input::get('after'));

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
			$response = Subreddit::submitPost(Input::all());

			return Response::json($response);
		}

		return Response::make('Bad input.', 400);		
	}

	public function indexProfile($user, $category = 'overview') {
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

		return Response::json([['content' => \View::make('errors.nodata')->render()]]);
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

		return Response::json($response);
	} 

	public function destroyVote($id) {
		$response = Reddit::fetch('api/vote', [
			'dir' => '0',
			'id' => $id
		], 'POST'); 

		return Response::json($response);		
	} 


	public function storeSave($id) {
		$response = Reddit::fetch('api/save', [
			'id' => $id
		], 'POST'); 

		return Response::json($response);
	} 

	public function destroySave($id) {
		$response = Reddit::fetch('api/unsave', [
			'id' => $id
		], 'POST'); 

		return Response::json($response);		
	} 


	public function storeSubscribe($id) {
		$subreddit = Subreddit::getSubredditData($id);

		$response = Reddit::fetch('api/subscribe', [
			'action' => 'sub',
			'sr' => 't5_'.$subreddit['data']['id']
		], 'POST'); 

		return Response::json($response);
	} 

	public function destroySubscribe($id) {
		$subreddit = Subreddit::getSubredditData($id);

		$response = Reddit::fetch('api/subscribe', [
			'action' => 'unsub',
			'sr' => 't5_'.$subreddit['data']['id']
		], 'POST'); 

		return Response::json($response);		
	} 
}
