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
		'Ensphere\Authentication\Console\Commands\Inspire',
		'Ensphere\Authentication\Console\Commands\GenerateAssets',
		'Ensphere\Authentication\Console\Commands\Registration',
		'Ensphere\Authentication\Console\Commands\ModuleName',
		'Ensphere\Authentication\Console\Commands\Export',
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
