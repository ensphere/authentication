<?php namespace Ensphere\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use Ensphere\Authentication\Models\User;

class ConfigServiceProvider extends ServiceProvider {

	/**
	 * Overwrite any vendor / package configuration.
	 *
	 * This service provider is intended to provide a convenient location for you
	 * to overwrite any "vendor" or package configuration that you may want to
	 * modify before the application handles the incoming request / command.
	 *
	 * @return void
	 */
	public function register()
	{
		config([
			'auth' => [
				'providers' => [
		        	'users' => [
		            	'driver' => 'eloquent',
		            	'model' => User::class,
		        	]
		        ],
		        'defaults' => [
			        'guard' => 'web',
			        'passwords' => 'users',
			    ],
			    'guards' => [
			        'web' => [
			            'driver' => 'session',
			            'provider' => 'users',
			        ],
			        'api' => [
			            'driver' => 'token',
			            'provider' => 'users',
			        ],
			    ],
			    'passwords' => [
			        'users' => [
			            'provider' => 'users',
			            'email' => 'ensphere.auth::auth.emails.password',
			            'table' => 'password_resets',
			            'expire' => 60,
			        ],
			    ],
		    ]
		]);
	}

}
