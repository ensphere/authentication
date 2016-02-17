<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
*/

$this->get('/', function(){
	return view('ensphere');
});

$this->group([ 'middleware' => 'web', 'prefix' => 'admin' ], function () {

	$this->get( '/', function(){
		return redirect( route( 'get.dashboard' ) );
	});

    $this->get('login', 					[ 'as' => 'get.login', 'uses' => 'Auth\AuthController@showLoginForm' ]);
	$this->post('login',					[ 'as' => 'post.login', 'uses' => 'Auth\AuthController@login' ]);
	$this->get('logout', 					[ 'as' => 'get.logout', 'uses' => 'Auth\AuthController@logout' ]);
	$this->get('signedup', 					[ 'as' => 'get.signedup', 'uses' => 'Auth\AuthController@signedUp' ]);

	$this->get('register', 					[ 'as' => 'get.register', 'uses' => 'Auth\AuthController@getRegister'] );
	$this->post('register', 				[ 'as' => 'post.register', 'uses' => 'Auth\AuthController@register' ]);

	$this->get('password/reset/{token?}', 	[ 'as' => 'get.reset', 'uses' => 'Auth\PasswordController@showResetForm'] );
	$this->post('password/email', 			[ 'as' => 'post.sendEmail', 'uses' => 'Auth\PasswordController@sendResetLinkEmail'] );
	$this->post('password/reset', 			[ 'as' => 'post.reset', 'uses' => 'Auth\PasswordController@reset'] );
    $this->get('dashboard', 				[ 'as' => 'get.dashboard', 'uses' => 'DashboardController@index'] );

});
