<?php

class ApiController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($subreddit = NULL) 
	{
		$data = Subreddit::fetch($subreddit, Input::get('after'));

		if($data) {
			return Response::json($data);
		}

		return Response::make('Failed to get any data', 404);
	}


}
