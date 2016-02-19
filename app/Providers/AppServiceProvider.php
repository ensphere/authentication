<?php namespace Ensphere\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use Libs\Helper;

class AppServiceProvider extends ServiceProvider {

	/**
	 * [isModule description]
	 * @return boolean [description]
	 */
	public static function isModule() {
		return file_exists( __DIR__ . "/../../../../../vendor" );
	}


	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom( __DIR__ . '/../../resources/views', 'ensphere.auth' );
		if( self::isModule() ) {
			$this->publishes( \Libs\Config\Publish::bower([
				__DIR__ . '/../../public/package/ensphere/authentication/' => base_path( 'public/package/ensphere/authentication/' ),
				__DIR__ . '/../../config/auth.php' => config_path( 'auth.php' ),
				__DIR__ . '/../../resources/database/migrations/' => database_path( 'migrations/vendor/ensphere/authentication/' )
			], __DIR__ ));
		}
	}

	/**
	 * REGISTER MODULE CONTRACTS IN THE REGISTRATION FILE SO THEY CAN BE EXTENDED PER APPLICATION
	 */
	public function register()
	{
		$contracts = \Libs\Providers\Service::contracts([
			// THESE ARE APPLICATION CONTRACTS.

		]);
		foreach( $contracts as $blueprint => $contract ) {
			$this->app->bind( $blueprint, $contract );
		}
	}
}
