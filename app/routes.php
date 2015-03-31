<?php

Route::get('/', ['as' => 'home', function() {
	
	return View::make('pages.home');
	
}]);

Route::post('product/image', ['as' => 'product.image', 'uses' => 'ProductController@upload']);
Route::get('product/types', ['as' => 'product.types', 'uses' => 'ProductController@types']);
Route::get('product/by/type', ['as' => 'product.getByType', 'uses' => 'ProductController@getByType']);

Route::resource('product', 'ProductController');

Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function() {

	Route::get('/', ['as' => 'admin.index', function() {

		return View::make('pages.admin');

	}]);

});




