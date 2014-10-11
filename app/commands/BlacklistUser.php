<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BlacklistUser extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:blacklist';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Stop the user from being displayed on page.';

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
		$data = $this->argument('user');

		$user = new \BlacklistUsers;
		$user['user'] = $data;
		$user->save();

		Cache::forget('blacklisted_users');

		$this->info('User '.$data.' is now blacklisted');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('user', InputArgument::REQUIRED, 'You must define a user.'),
		);
	}

}
