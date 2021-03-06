<?php namespace Ensphere\Authentication\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use LukeSnowden\Menu\Menu;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Ensphere\Authentication\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		//
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router){
			require __DIR__ . '/../Http/routes.php';
		});
		$this->menuItems();
	}

	/**
	 * [menuItems description]
	 * @return [type] [description]
	 */
	protected function menuItems()
	{
		Menu::addItem([
			'text' => 'Dashboard',
			'URL' => 'route:get.dashboard',
			'reference' => 'dashboard'
		])
		->toMenu( 'main' );
		Menu::setMenuType( 'semantic-ui-vertical', 'main', 'LukeSnowden\Menu\Styles' );
	}

}
