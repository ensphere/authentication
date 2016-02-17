<?php namespace Ensphere\Authentication\Console\Commands\Ensphere\Install\Update;

use Ensphere\Authentication\Console\Commands\Ensphere\Traits\Module as ModuleTrait;
use Illuminate\Console\Command as IlluminateCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Command extends IlluminateCommand {

	use ModuleTrait;

	/**
	 * [$name description]
	 * @var string
	 */
	protected $name = 'ensphere:update';

	/**
	 * [$description description]
	 * @var string
	 */
	protected $description = 'Update vendor and application dependencies.';

	/**
	 * [$currentStructure description]
	 * @var [type]
	 */
	private $currentStructure;

	/**
	 * [fire description]
	 * @return [type] [description]
	 */
	public function fire()
	{
		$this->generateRegistrationFile();
		$this->migrateRun();
		$this->publishVendorAssets();
		$this->combineVendorAssets();
		$this->runGulp();
	}

	/**
	 * [migrateRun description]
	 * @return [type] [description]
	 */
	private function migrateRun()
	{
		$this->info( shell_exec( "php artisan ensphere:migrate run" ) );
	}

	/**
	 * [generateRegistrationFile description]
	 * @return [type] [description]
	 */
	private function generateRegistrationFile()
	{
		$this->info( shell_exec( "php artisan ensphere:register" ) );
	}

	/**
	 * [publishVendorAssets description]
	 * @return [type] [description]
	 */
	private function publishVendorAssets()
	{
		$this->info( shell_exec( "php artisan vendor:publish --force" ) );
	}

	/**
	 * [combineVendorAssets description]
	 * @return [type] [description]
	 */
	private function combineVendorAssets()
	{
		$this->info( shell_exec( "php artisan ensphere:assets" ) );
	}

	/**
	 * [runGulp description]
	 * @return [type] [description]
	 */
	private function runGulp()
	{
		$this->info( shell_exec( "gulp" ) );
	}

	/**
	 * [getArguments description]
	 * @return [type] [description]
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * [getOptions description]
	 * @return [type] [description]
	 */
	protected function getOptions()
	{
		return [];
	}

}