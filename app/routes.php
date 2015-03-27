<?php

Route::get('/', ['as' => 'home', function() {
	
	return View::make('pages.home');
	
}]);


Route::resource('products', 'ProductsController');


Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function() {

	Route::get('/', ['as' => 'admin.index', function() {

		return View::make('pages.admin');

	}]);


});




