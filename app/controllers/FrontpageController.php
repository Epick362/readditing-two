<?php

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

	public function subreddit($subreddit = 'home')
	{
		$viewData = array();
		$viewData['subreddit'] = $subreddit;

		$links = ['http://www.cnn.com/2014/04/25/justice/texas-family-wins-fracking-lawsuit/index.html',
				'http://www.sciencedaily.com/releases/2014/04/140425104714.htm', 
				'http://www.thewire.com/technology/2014/04/elon-musks-space-x-claims-an-evolutionary-breakthrough-in-rocket-technology/361244/'];

		$i = 0;
		foreach($links as $link) {
			$readability = new Readditing\Readability\Readability($link);
			$readability->init();

			$viewData['posts'][$i]['title'] = $readability->getTitle()->innerHTML;
			$viewData['posts'][$i]['content'] = $readability->getContent()->innerHTML;

			$i++;
		}

		return View::make('frontpage', $viewData);
	}

	public function auth() {
		return View::make('frontpage')->with('subreddit', 'Logged In');
	}
}