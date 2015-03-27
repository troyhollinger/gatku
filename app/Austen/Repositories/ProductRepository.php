<?php


namespace Austen\Repositories;

use Product;

class ProductRepository implements ProductRepositoryInterface {

	
	public function getAll() {

		return Product::all();

	}

	public function find($slug) {

		$product = Product::where('slug', '=', $slug)->first();

		return $product;

	}


	public function store($input) {




	}


}