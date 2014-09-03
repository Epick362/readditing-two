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

	public function storeVote($id) {
		$response = Reddit::fetch('api/vote', [
			'dir' => 1,
			'id' => $id
		], 'POST'); 

		dd($response);

		return Response::json($response);
	} 

	public function destroyVote($id) {
		
	} 


	public function storeSave($id) {

	} 

	public function destroySave($id) {
		
	} 
}
