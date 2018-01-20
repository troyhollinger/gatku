<?php

use Austen\Repositories\ImageRepository;

class HomeSettingController extends BaseController {

	protected $image;

	public function __construct(ImageRepository $image) {

		$this->image = $image;

	}

	/**
	 * Display a listing of the resource.
	 * GET /homesetting
	 *
	 * @return Response
	 */
	public function index() {
		
		try {
			
			$homeSettings = HomeSetting::orderBy('id', 'desc')->first();
			//$homeSettings = HomeSetting::all();

		} catch (Exception $e) {
			
			return Response::json(['message' => 'Sorry, home setting could not be retrieved.'], 404);

		}

		return Response::json(['data' => $homeSettings], 200);

	}


	/**
	 * Store a newly created resource in storage.
	 * POST /homesetting
	 *
	 * @return Response
	 */
	public function store() {
		try {
			$homeSetting = new HomeSetting;
			$homeSetting->logo = Input::get('logo');
			$homeSetting->button_color = Input::get('button_color');
			$homeSetting->hamburger_menu_color = Input::get('hamburger_menu_color');
			$homeSetting->cart_button_color = Input::get('cart_button_color');
			$homeSetting->image = Input::get('image');
			$homeSetting->mobile_image = Input::get('mobile_image');
			$homeSetting->image_info = Input::get('image_info');
			$homeSetting->image_credit = Input::get('image_credit');
			$homeSetting->save();
		} catch (Exception $e) {
			Log::error($e);

			return Response::json(['message' => 'Sorry, there was a problem saving the image'], 404);
		}

		return Response::json(['message' => 'Home setting saved!'], 200);
	}

	
	/**
	 * Update the specified resource in storage.
	 * PUT /homesetting/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /homesetting/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function upload() {

		$file = Input::file('file');

		$upload = $this->image->upload($file, 'img/home-images/');

		if ($upload === false) {

			return Response::json(['message' => 'Sorry, something went wrong during the upload'], 404);

		}

		return Response::json(['data' => $upload['imagePath']], 200);

	}

}