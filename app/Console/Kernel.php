<?php namespace Ensphere\Authentication\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [

		'Ensphere\Authentication\Console\Commands\Ensphere\Rename\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Import\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Export\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Bower\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Migrate\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Registration\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Install\Command',
		'Ensphere\Authentication\Console\Commands\Ensphere\Install\Update\Command',

	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
				 ->hourly();
	}

}
