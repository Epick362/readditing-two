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

	public function subreddit($subreddit = 'home')
	{
		$viewData = array();
		$viewData['subreddit'] = $subreddit;

		$links = ['http://www.cnn.com/2014/04/25/justice/texas-family-wins-fracking-lawsuit/index.html#',
				'http://www.sciencedaily.com/releases/2014/04/140425104714.htm', 
				'http://www.thewire.com/technology/2014/04/elon-musks-space-x-claims-an-evolutionary-breakthrough-in-rocket-technology/361244/'];

		$i = 0;
		foreach($links as $link) {
			$saved_article = Article::where('url', $link)->first();
			if(! $saved_article) {
				$readability = new Readditing\Readability\Readability($link);
				$readability->init();

				$viewData['posts'][$i]['title'] = $readability->getTitle()->innerHTML;
				$viewData['posts'][$i]['content'] = $readability->getContent()->innerHTML;

				$article = new Article;
				$article->url = $link;
				$article->title = $readability->getTitle()->innerHTML;
				$article->content = $readability->getContent()->innerHTML;
				$article->save();
			}else{
				$article = $saved_article;

				$viewData['posts'][$i]['title'] = $article->title;
				$viewData['posts'][$i]['content'] = $article->content;
				$viewData['posts'][$i]['extra'] = 'cached';
			}

			$i++;
		}

		$formatter = Formatter::provider('imgur', array('data' => 'lol'));
		print_r($formatter->greeting());

		return View::make('frontpage', $viewData);
	}
}