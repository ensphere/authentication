<?php namespace Ensphere\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use EnsphereCore\Libs\Config\Publish;
use EnsphereCore\Libs\Providers\Service;
use Ensphere\Authentication\Contents\Buttons;

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
	public function boot( Application $app )
	{
		$this->loadViewsFrom( __DIR__ . '/../../resources/views', 'ensphere.auth' );
		if( self::isModule() ) {
			$this->publishes( Publish::bower([
				__DIR__ . '/../../public/package/ensphere/authentication/' => base_path( 'public/package/ensphere/authentication/' ),
				__DIR__ . '/../../config/auth.php' => config_path( 'auth.php' ),
				__DIR__ . '/../../resources/database/migrations/' => database_path( 'migrations/vendor/ensphere/authentication/' )
			], __DIR__ ));
		}
		$this->registerContainers( $app['ensphere.container'] );
	}

	/**
	 * Register Areas to bind functionality or views to.
	 * @param  Application $app [description]
	 * @return [type]           [description]
	 */
	public function registerContainers( $container )
	{
		$container->register( 'dashboard-top-bar' )
			->register([ Buttons::class ]);
		$container->register( 'dashboard-right-left' );
		$container->register( 'dashboard-left' );
		$container->register( 'dashboard-right-right' );
	}

	/**
	 * REGISTER MODULE CONTRACTS IN THE REGISTRATION FILE SO THEY CAN BE EXTENDED PER APPLICATION
	 */
	public function register()
	{
		if( ! self::isModule() ) {
			$contracts = Service::contracts([
				// THESE ARE APPLICATION CONTRACTS.

			]);
			foreach( $contracts as $blueprint => $contract ) {
				$this->app->bind( $blueprint, $contract );
			}
		}
	}
}
