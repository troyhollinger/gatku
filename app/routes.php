<?php

Route::get('/', ['as' => 'home', function() {
	
	return View::make('pages.home');
	
}]);



Route::get('product/{slug?}', ['as' => 'product', function() {

	return View::make('pages.product');

}]);