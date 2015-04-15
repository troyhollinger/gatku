<?php

Route::get('/', ['as' => 'home', function() {
	
	return View::make('pages.home');
	
}]);

Route::post('product/image', ['as' => 'product.image', 'uses' => 'ProductController@upload']);
Route::get('product/types', ['as' => 'product.types', 'uses' => 'ProductController@types']);
Route::get('product/by/type', ['as' => 'product.getByType', 'uses' => 'ProductController@getByType']);
Route::get('product/get/{id}', ['as' => 'product.get', 'uses' => 'ProductController@get']);

Route::resource('product', 'ProductController');

Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function() {

	Route::get('/', ['as' => 'admin.index', function() {

		return View::make('pages.admin');

	}]);

});

Route::resource('order', 'OrderController');


Route::get('cart', ['as' => 'cart.getItems', 'uses' => 'CartController@getItems']);
Route::post('cart', ['as' => 'cart.addItem', 'uses' => 'CartController@addItem']);


Route::get('thankyou', ['as' => 'thankyou', function() {

	return View::make('pages.thankyou');

}]);

Route::get('images', function() {

	// TODO : use this forumula to retrieve images so that
	// new products can choose already-uploaded images as their 
	// product images.

	$photos = [];

	chdir(public_path() . '/img/uploads/');

	foreach(glob('*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE) as $index => $file) {

		$photos[$index] = $file;

	}

	var_dump($photos);

});


