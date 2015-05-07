<?php

Route::get('/', ['as' => 'home', function() {
	
	return View::make('pages.home');
	
}]);

Route::post('product/image', ['as' => 'product.image', 'uses' => 'ProductController@upload']);
Route::get('product/types', ['as' => 'product.types', 'uses' => 'ProductController@types']);
Route::get('product/by/type', ['as' => 'product.getByType', 'uses' => 'ProductController@getByType']);
Route::get('product/by/slug/{slug}', ['as' => 'product.getBySlug', 'uses' => 'ProductController@getBySlug']);
Route::get('product/get/{id}', ['as' => 'product.get', 'uses' => 'ProductController@get']);
Route::get('product/photos/{id}', ['as' => 'product.customerPhotos', 'uses' => 'ProductController@photos']);
Route::get('size/by/slug/{slug}', ['as' => 'size.bySlug', 'uses' => 'ProductController@getSizeBySlug']);

Route::resource('product', 'ProductController');

Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function() {

	Route::get('/', ['as' => 'admin.index', function() {

		return View::make('pages.admin');

	}]);

});

Route::resource('order', 'OrderController');

Route::resource('you-image', 'YouImageController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::post('you-image/upload', ['as' => 'you-image.upload', 'uses' => 'YouImageController@upload']);

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


