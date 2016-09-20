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
	public function index() {
		$orders = $this->order->all();

		if (!$orders) {
			return Response::json(['message' => 'Sorry, there was an error'], 404);
		}
		$totalCount = DB::table('orders')->count();
		return Response::json(['data' => $orders, 'total_count' => $totalCount], 200);
	}


	public function orderall($itemsPerPage, $pagenumber){
		$totalCount = DB::table('orders')->count();
		$orders = Order::with('items.addons.product', 'items.product', 'customer', 'items.size', 'tracking', 'shipping')->orderBy('created_at', 'desc')->take($itemsPerPage)->skip($itemsPerPage*($pagenumber-1))->get();
		return Response::json(['data' => $orders, 'total_count' => $totalCount], 200);
	}
	
	/**
	 * Store a newly created resource in storage.
	 * POST /order
	 *
	 * @return Response
	 */
	public function store() {
		$allData = Input::all();
		$order = $this->order->process(Input::all());

		if ($order !== true) {
			if ($order !== false) {
				return Response::json(['message' => $order], 404);
			} else {
				return Response::json(['message' => 'Sorry, something went wrong on our end. We are fixing it.'], 404);
			}
		}
		$fname = $allData['form']['firstName'];
		$email = $allData['form']['email'];
		$country = $allData['form']['country'];
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        // MailChimp API credentials
        $apiKey = 'dbb4a319f336c9f4ceb826cb0c6f102e-us9';
        if(strtolower($country) == 'australia'){
        	$listID = '451477286e'; // austrelia
        }else{
        	$listID = '793e0e910d'; // gatku customer
        }
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
        
        // member information
        $json = json_encode([
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME'     => $fname
            ]
        ]);
        
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
    
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