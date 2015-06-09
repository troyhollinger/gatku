<?php


namespace Austen\Repositories;

use Product;
use ProductType;
use Log;
use Addon;
use Size;

class ProductRepository implements ProductRepositoryInterface {

	
	public function all() {

		$products = Product::with('type', 'addons', 'availability')->get();

		Log::info($products);

		return $products;

	}

	public function get($id) {

		try {
			
			$product = Product::findOrFail($id);

			$product->load('type', 'addons.product.type', 'sizes');

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return $product;

	}

	public function find($slug) {

		try {
			
			$product = Product::where('slug', '=', $slug)->with('type')->first();

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return $product;

	}


	public function store($input) {

		try {
		
			$product = new Product;
			
			$result = $this->assignData($product, $input);

			$result->save();

			if (isset($input['addonSelection'])) $this->assignAddons($result, $input);

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		return true;

	}

	public function update($id, $input) {

		try {
			
			$product = Product::findOrFail($id);
		
			$result = $this->assignData($product, $input);

			$result->save();

			$this->assignAddons($result, $input);

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
			$shrinker = ProductType::where('name', '=', 'shrinker')->first()->products;
			$extras = ProductType::where('name', '=', 'extra')->first()->products;
			$apparel = ProductType::where('name', '=', 'apparel')->first()->products;
			$glasses = ProductType::where('name', '=', 'glass')->first()->products;

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		$products = [
			'heads' => $heads,
			'poles' => $poles,
			'shrinker' => $shrinker,
			'extras' => $extras,
			'apparel' => $apparel,
			'glasses' => $glasses
		];

		return $products;

	}

	public function getSizeBySlug($slug) {

		try {
			
			$size = Size::where('slug', '=', $slug)->first();

		} catch (Exception $e) {

			Log::error($e);

			return false;
			
		}

		return $size;

	}


	/**
	 * Assigns product data from input
	 *
	 * @return object $product
	 */
	private function assignData($product, $data) {

		$product->typeId = $data['typeId'];
		if (isset($data['attachedImage'])) $product->attachedImage = $data['attachedImage'];
		if (isset($data['detachedImage'])) $product->detachedImage = $data['detachedImage'];
		if (isset($data['emailImage'])) $product->emailImage = $data['emailImage'];
		if (isset($data['thumb'])) $product->thumb = $data['thumb'];
		if (isset($data['availabilityTypeId'])) $product->availabilityTypeId = $data['availabilityTypeId'];
		$product->name = $data['name'];
		$product->shortName = $data['shortName'];
		$product->slug = $data['slug'];
		$product->price = $data['price'];
		$product->description = $data['description'];
		if (isset($data['metaDescription'])) $product->metaDescription = $data['metaDescription'];
		if (isset($data['length'])) $product->length = $data['length'];
		if (isset($data['maneuverability'])) $product->maneuverability = $data['maneuverability'];
		if (isset($data['trajectory'])) $product->trajectory = $data['trajectory'];
		if (isset($data['balance'])) $product->balance = $data['balance'];
		if (isset($data['stealth'])) $product->stealth = $data['stealth'];

		return $product;

	}


	/**
	 * Assign addons
	 *
	 * 
	 */
	private function assignAddons($product, $data) {

		Log::info("Assign Addons is being called");

		$addons = $data['addonSelection'];
		// get existing addons for product
		$existing = $product->addons;

		// loop through the data array
		foreach($addons as $addon) {

			if (count($existing)) {

				$match = false;

				// loop through existing addons
				foreach($existing as $existingAddon) {

					// there is a match
					if ($existingAddon->childId == $addon['id']) {

						if ($addon['isAddon'] === false) {

							$existingAddon->delete();

							break;

						} 

						$match = true;

					} 

				}

				if ($match === false && $addon['isAddon'] === true) {

					$newAddon = new Addon;
					$newAddon->parentId = $product->id;
					$newAddon->childId = $addon['id'];
					$newAddon->save();

				}

			} else {

				if ($addon['isAddon'] === true) {

					$newAddon = new Addon;
					$newAddon->parentId = $product->id;
					$newAddon->childId = $addon['id'];
					$newAddon->save();

				}

			}

		}

	}


}










