<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function(){
	return view('ensphere');
});

Route::group([ 'middleware' => 'web' ], function () {

    Route::auth();
    Route::get('/home', 'HomeController@index');

});
