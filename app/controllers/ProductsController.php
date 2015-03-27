<?php


use Austen\Repositories\ProductRepositoryInterface;


class ProductsController extends BaseController {

	protected $product;

	public function __construct(ProductRepositoryInterface $product) {

		$this->product = $product;

	}


	/**
	 * Display a listing of the resource.
	 * GET /products
	 *
	 * @return Response
	 */
	public function index() {
		
		$products = $this->product->getAll();


	}

	/**
	 * Show the form for creating a new resource.
	 * GET /products/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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

	/**
	 * Display the specified resource.
	 * GET /products/{id}
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug) {

		try {
			
			$productId = $this->product->find($slug)->id;

		} catch (Exception $e) {
			
			Log::error($e);

		}

		return View::make('pages.product', ['productId' => $productId]);

	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /products/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /products/{id}
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
	 * DELETE /products/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}