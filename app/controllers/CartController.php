<?php



class CartController extends BaseController {

	public function getItems() {

		$test = Cookie::get('item1');

		// Log::info($test);

		return Response::json(['data' => $test], 200);

	}


	public function addItem() {

		try {
			
			$item = Input::get('item');

			$cookie = Cookie::make('item1', $item, 5);

			// Log::info($item);

		} catch (Exception $e) {
			
			Log::error($e);

			return Response::json(['message' => 'something went wrong'], 404);

		}

		// return Response::json([], 200)->headers->setCookie($cookie);
		return Response::make()->withCookie($cookie);

	}


}