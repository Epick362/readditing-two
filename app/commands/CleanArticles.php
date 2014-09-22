<?php

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CleanArticles extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'readditing:cleanArticles';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cleans the Articles table from articles older than a day.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$affected_rows = Article::where('updated_at' >= Carbon::now()->subDays(1)->toDateTimeString())->delete();

		if($affected_rows) {
			$this->info('Articles purged.');
		}else{
			$this->error('Article purging failed.');
		}
	}

}
