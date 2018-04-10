<?php


namespace Austen\Repositories;

use Discount;
use Log;

class DiscountRepository {

	public function all() {
		$discounts = Discount::all();
		Log::info($discounts);
		return $discounts;
	}

//	public function get($id) {
//
//		try {
//
//			$product = Product::findOrFail($id);
//
//			$product->load('type', 'addons.product.type', 'sizes', 'availability');
//
//		} catch (Exception $e) {
//
//			Log::error($e);
//
//			return false;
//
//		}
//
//		return $product;
//
//	}


    /**
     * @param $input
     * @return bool
     */
	public function store($input) {

		try {
			$discount = new Discount;
			$result = $this->assignData($discount, $input);
			$result->save();
		} catch (Exception $e) {
			Log::error($e);
			return false;
		}
		return true;
	}

    /**
     * @param $id
     * @param $input
     * @return bool
     */
	public function update($id, $input) {
		try {
			$discount = Discount::findOrFail($id);
			$result = $this->assignData($discount, $input);
			$result->save();
		} catch (Exception $e) {
			Log::error($e);
			return false;
		}
		return true;
	}

    /**
     * @param $id
     * @return bool
     */
	public function destroy($id) {
	    try {
            $discount = Discount::findOrFail($id);
            $discount->delete();
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
        return true;
	}

    /**
     * Assigns discount data from input
     *
     * @param Discount $discount
     * @param $data
     * @return Discount
     */
	private function assignData($discount, $data) {
		$discount->id = $data['id'];
		$discount->discount = $data['discount'];
		$discount->code = $data['code'];

		return $discount;
	}
}
