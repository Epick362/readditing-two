<?php

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddSiteNotification extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'notification:add';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Adds a notification to be displayed at the top of the page.';

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
		$message = $this->argument('message');

		$notif = new \SiteNotifications;
		$notif['message'] = $message;
		$notif['type'] = $this->option('type');
		$notif['show_until'] = Carbon::now()->addHours($this->option('duration'))->toDateTimeString();
		$notif->save();

		$this->info('Notification added.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('message', InputArgument::REQUIRED, 'Notification body.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('type', null, InputOption::VALUE_OPTIONAL, 'Notification type.', 'info'),
			array('duration', null, InputOption::VALUE_OPTIONAL, 'How long will the notification be displayed since added.', 24),
		);
	}

}
