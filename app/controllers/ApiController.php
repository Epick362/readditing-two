<?php

class ApiController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($subreddit = NULL)
	{
		$data = Subreddit::fetch($subreddit, Input::get('formatted'));

		if($data) {
			return Response::json($data);
		}

		return App::abort(404);
	}


}
