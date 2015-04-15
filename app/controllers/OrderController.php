<?php

use Austen\Repositories\OrderRepository;

class OrderController extends BaseController {

	protected $order;

	public function __construct(OrderRepository $order) {

		$this->order = $order;

	}

	/**
	 * get a listing of the resource.
	 * GET /order
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	
	/**
	 * Store a newly created resource in storage.
	 * POST /order
	 *
	 * @return Response
	 */
	public function store() {

		// Log::info(Input::all());
		
		$order = $this->order->process(Input::all());

		if ($order === false) {

			return Response::json(['message' => 'Sorry, the order could not be made'], 404);

		}

		return Response::json(['message' => 'Thank you for the order!'], 200);

	}

	/**
	 * Display the specified resource.
	 * GET /order/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /order/{id}/edit
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
	 * PUT /order/{id}
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
	 * DELETE /order/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}