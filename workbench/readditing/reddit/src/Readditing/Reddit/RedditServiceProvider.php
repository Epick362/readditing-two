<?php namespace Readditing\Reddit;

use Illuminate\Support\ServiceProvider;

class RedditServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
	* Bootstrap the application events.
	*
	* @return void
	*/
	public function boot()
	{
		$this->package('readditing/reddit');
	}
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['reddit'] = $this->app->share(function($app)
		{
			return new Reddit;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Reddit', 'Readditing\Reddit\Facades\Reddit');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('reddit');
	}

}
