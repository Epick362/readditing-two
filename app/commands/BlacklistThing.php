<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BlacklistThing extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'thing:blacklist';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Stop a thing from being displayed on page.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$data = $this->argument('thing');

		$user = new \BlacklistThings;
		$user['thing'] = 't3_'.$data;
		$user->save();

		Cache::forget('blacklisted_things');

		$this->info('Thing '.$data.' is now blacklisted');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('thing', InputArgument::REQUIRED, 'You must define a thing.'),
		);
	}

}
