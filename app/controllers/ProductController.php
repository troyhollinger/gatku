<?php


use Austen\Repositories\ProductRepositoryInterface;
use Austen\Repositories\ImageRepository;


class ProductController extends BaseController {

	protected $product;

	public function __construct(ProductRepositoryInterface $product, ImageRepository $image) {

		$this->product = $product;
		$this->image = $image;

	}


	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */
	public function index() {
		
		$products = $this->product->all();

		return Response::json(['data' => $products], 200);

	}

	
	/**
	 * Store a newly created resource in storage.
	 * POST /products
	 *
	 * @return Response
	 */
	public function store() {

		if ($this->product->store(Input::all())) {

			return Response::json([], 200);

		} else {

			return Response::json(['message' => 'Sorry, the product could not be created'], 404);

		}

	}

	public function get($id) {

		$product = $this->product->get($id);

		if ($product === false) {

			return Response::json(['sorry, there was an error'], 404);

		}

		return Response::json(['data' => $product], 200);

	}

	public function getBySlug($slug) {

		$product = $this->product->find($slug);

		if ($product === false) {

			return Response::json(['message' => 'Sorry, the product could not be retrieved'], 404);

		}

		return Response::json(['data' => $product], 200);

	}

	/**
	 * Display the specified resource.
	 * GET /products/{id}
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug) {
		
		$product = $this->product->find($slug);

		if ($product === false || $product === null) {

			return Redirect::route('home');

		}	

		return View::make('pages.product', ['product' => $product]);

	}


	/**
	 * Upload a file from $_POST request
	 * POST /products/image
	 *
	 * @return Response
	 */
	public function upload() {

		$file = Input::file('file');

		$upload = $this->image->upload($file, 'img/uploads/');

		if ($upload === false) {

			return Response::json(['message' => 'Sorry, There was an error uploading this image.'], 404);

		}

		return Response::json(['data' => $upload['imagePath']], 200);

	}


	/**
	 * Update the specified resource in storage.
	 * PUT /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		
		$input = Input::all();

		$update = $this->product->update($id, $input);

		if ($update === false) {

			return Response::json(['message' => 'Sorry, there was a problem updating this product.'], 404);

		}

		return Response::json(['message' => 'product updated'], 200);

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {

		//

	}


	/**
	 * Returns an array of product types
	 *
	 * @return Response
	 */
	public function types() {

		$types = $this->product->types();

		if ($types === false) {

			return Response::json(['message' => 'Sorry, there was problem retrieving the types'], 404);

		}

		return Response::json(['data' => $types], 200);

	}


	public function getByType() {

		$products = $this->product->getByType();

		if ($products === false) {

			return Response::json(['message' => 'Sorry, could not get products by type.'], 404);

		}

		return Response::json(['data' => $products], 200);

	}

}