<?php

use Readditing\Formatter\Formatter as Formatter;

class FrontpageController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	*/

	public function subreddit($subreddit = 'home', $after = NULL)
	{
		$viewData = array();
		$viewData['subreddit'] = $subreddit;

		$posts = Reddit::fetch('/hot.json');

		if(isset($posts['data']['children'])) {
			foreach($posts['data']['children'] as $_post) {

				$parts = parse_url($_post['data']['url']);

				$host = str_replace('www.', '', $parts['host']);
				$matches = array();
				preg_match('/(.*?)((\.co)?.[a-z]{2,4})$/i', $host, $matches);
				if(strchr($matches[1], '.')) {
					$_url = substr(strrchr($matches[1], '.'), 1);
				}else{
					$_url = $matches[1];
				}

				$formatter = Formatter::provider($_url, $_post);
				print_r($formatter->getContent());
				echo '<br/>';
			}
			die;
		}else{
			App::abort(503);
		}

		/*

		*/

		return View::make('frontpage', $viewData);
	}
}