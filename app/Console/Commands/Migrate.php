<?php namespace Ensphere\Authentication\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use DirectoryIterator;
use Artisan;

class Migrate extends Command {

	/**
	 * [$name description]
	 * @var string
	 */
	protected $name = 'ensphere:migrate';

	/**
	 * [$description description]
	 * @var string
	 */
	protected $description = 'Clears up the module to align with installation.';

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
		$this->currentStructure = $this->getCurrentVendorAndModuleName();
		switch( $this->argument('migration_command') ) {
			case 'run' :
				$this->runMigration();
			break;
			case 'create' :
				$this->createMigration();
			break;
		}
	}

	/**
	 * [createMigration description]
	 * @return [type] [description]
	 */
	private function createMigration() {
		$migrationName = $this->option('name');
		$databaseFolder = base_path( 'database/migrations/vendor/' . $this->currentStructure['vendor'] . '/' . $this->currentStructure['module'] . '/' );
		$result = Artisan::call( 'make:migration', array(
			'name' => $migrationName,
			'--path' => "database/migrations/vendor/" . $this->currentStructure['vendor'] . "/" . $this->currentStructure['module']
		));
		$this->info("migration file created in: database/migrations/vendor/" . $this->currentStructure['vendor'] . "/" . $this->currentStructure['module'] . "/");
	}

	/**
	 * [runMigration description]
	 * @return [type] [description]
	 */
	public function runMigration() {
		$this->line( 'running application migration' );
		Artisan::call('migrate');
		$this->line( 'running vendor migration' );
		$folder = base_path( 'database/migrations/vendor/' );
		foreach( new DirectoryIterator( $folder ) as $vendorInfo ) {
			if( $vendorInfo->isDir() && ! $vendorInfo->isDot() ) {
				$vendor = $vendorInfo->getBasename();
				foreach( new DirectoryIterator( $folder . $vendor ) as $moduleInfo ) {
					if( $moduleInfo->isDir() && ! $moduleInfo->isDot() ) {
						$module = $moduleInfo->getBasename();
						$result = Artisan::call( 'migrate', array(
							'--path' => "database/migrations/vendor/{$vendor}/{$module}/"
						));
					}
				}
			}
		}
	}


	/**
	 * [getCurrentVendorAndModuleName description]
	 * @return [type] [description]
	 */
	private function getCurrentVendorAndModuleName()
	{
		$composerDotJson = json_decode( file_get_contents( base_path('composer.json') ) );
		$psr4Autoload = $composerDotJson->autoload->{'psr-4'};
		$name = null;
		foreach( $psr4Autoload as $nameSpace => $folder ) {
			if( $folder == 'app/' ) {
				$name = $nameSpace;
				break;
			}
		}
		if( is_null( $name ) ) {
			$this->error('Could not find namespace from composer.json');
		}
		if( ! preg_match( "#^([a-z0-9]+)\\\([a-z0-9]+)\\\\$#is", $name, $match ) ) {
			$this->error('Could not find namespace from composer.json');
		}
		return [
			'vendor' => $this->getComputerNameFromCamelCase($match[1]),
			'module' => $this->getComputerNameFromCamelCase($match[2]),
			'camelCasedVendor' => $match[1],
			'camelCasedModule' => $match[2]
		];
	}

	/**
	 * [getComputerNameFromCamelCase description]
	 * @param  [type] $string [description]
	 * @return [type]         [description]
	 */
	private function getComputerNameFromCamelCase( $string )
	{
		return strtolower( implode( "-", array_filter( preg_split( "/(?=[A-Z])/", $string ) ) ) );
	}

	/**
	 * [getArguments description]
	 * @return [type] [description]
	 */
	protected function getArguments()
	{
		return [
			['migration_command', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * [getOptions description]
	 * @return [type] [description]
	 */
	protected function getOptions()
	{
		return [
			['name', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}