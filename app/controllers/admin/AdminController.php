<?php

namespace Readditing;

use \Carbon\Carbon as Carbon;

class AdminController extends \BaseController {

	public function getIndex() {
		$view['users'] = \Users::count();
		$view['recent'] = \Users::where('updated_at', '>=', Carbon::now()->subDays(7)->toDateTimeString())->count();

		$view['articles'] = \Article::count();
		$view['imgur'] = \ImgurCache::count();

		$view['last10'] = \Users::orderBy('updated_at', 'desc')->limit(10)->get();

		return \View::make('admin.dashboard', $view);		
	}
}
