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
			$this->publishes([
				__DIR__ . '/../../public/package/ensphere/authentication/' => base_path( 'public/package/ensphere/authentication/' ),
				__DIR__ . '/../../config/auth.php' => config_path( 'auth.php' ),
				__DIR__ . '/../../resources/database/migrations/' => database_path( 'migrations/vendor/authentication/' )
			]);
		}
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		// $this->app->bind(
		// 	'Illuminate\Contracts\Auth\Registrar',
		// 	'Ensphere\Authentication\Services\Registrar'
		// );
	}

}
