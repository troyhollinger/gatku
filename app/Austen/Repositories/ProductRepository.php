<?php


namespace Austen\Repositories;

use Product;
use ProductType;
use Log;

class ProductRepository implements ProductRepositoryInterface {

	
	public function all() {

		return Product::with('type')->get();

	}

	public function get($id) {

		try {
			
			$product = Product::findOrFail($id);

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return $product;

	}

	public function find($slug) {

		$product = Product::where('slug', '=', $slug)->first();

		return $product;

	}


	public function store($input) {

		try {
		
			$product = new Product;
			$product->typeId = $input['typeId'];
			$product->attachedImage = $input['attachedImage'];
			$product->detachedImage = $input['detachedImage'];
			if (isset($input['thumb'])) $product->thumb = $input['thumb'];
			$product->name = $input['name'];
			$product->shortName = $input['shortName'];
			$product->slug = $input['slug'];
			$product->price = $input['price'];
			$product->description = $input['description'];
			if (isset($input['maneuverability'])) $product->maneuverability = $input['maneuverability'];
			if (isset($input['trajectory'])) $product->trajectory = $input['trajectory'];
			if (isset($input['balance'])) $product->balance = $input['balance'];
			if (isset($input['stealth'])) $product->stealth = $input['stealth'];

			$product->save();

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return true;

	}

	public function update($id, $input) {

		try {
			
			$product = Product::findOrFail($id);
			$product->typeId = $input['typeId'];
			$product->attachedImage = $input['attachedImage'];
			$product->detachedImage = $input['detachedImage'];
			if (isset($input['thumb'])) $product->thumb = $input['thumb'];
			$product->name = $input['name'];
			$product->shortName = $input['shortName'];
			$product->slug = $input['slug'];
			$product->price = $input['price'];
			$product->description = $input['description'];
			if (isset($input['maneuverability'])) $product->maneuverability = $input['maneuverability'];
			if (isset($input['trajectory'])) $product->trajectory = $input['trajectory'];
			if (isset($input['balance'])) $product->balance = $input['balance'];
			if (isset($input['stealth'])) $product->stealth = $input['stealth'];
			$product->save();


		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return true;

	}

	public function destroy($id) {



	}

	public function types() {

		try {
			
			$types = ProductType::all();	

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return $types;

	}


	public function getByType() {

		try {
			
			$heads = ProductType::where('name', '=', 'head')->first()->products;
			$poles = ProductType::where('name', '=', 'pole')->first()->products;
			// $extras = ProductType::where('name', '=', 'extra')

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		$products = [
			'heads' => $heads,
			'poles' => $poles
		];

		return $products;

	}

}