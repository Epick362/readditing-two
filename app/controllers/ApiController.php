<?php

class ApiController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function subreddit($subreddit = NULL) 
	{
		$data = Subreddit::getPosts($subreddit, Input::get('after'));

		if($data) {
			return Response::json($data);
		}

		return Response::make('Could not get any data.', 503);
	}

	public function indexComment($subreddit, $thing) {
		$data = Subreddit::getComments($subreddit, $thing);

		if($data) {
			return Response::json($data);
		}

		return Response::make('Could not get any data.', 503);
	}

	public function storeVote($id) {
		$response = Reddit::fetch('api/vote', [
			'dir' => '1',
			'id' => $id
		], 'POST'); 

		dd($response);

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
