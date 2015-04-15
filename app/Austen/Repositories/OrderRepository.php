<?php namespace Austen\Repositories;

use Order;
use OrderItem;
use Stripe_Charge;
use Product;
use Austen\Repositories\CustomerRepository;
use Log;
use Mail;

class OrderRepository {

	protected $customer;

	public function __construct(CustomerRepository $customer) {

		$this->customer = $customer;

	}

	public function process($input) {

		// validate input
		if (!$this->validateInput($input)) {

			return false;

		}	

		try {
			
			$customer = $this->customer->store($input['form']);

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}

		try {
			
			//create order object
			$order = new Order;
			//assign form data
			$order = $this->assignFields($order, $customer, $input['form']);

			// save order
			$order->save();

		} catch (Exception $e) {
			
			Log::error($e);

			return false;

		}
		
		//calculate total
		try {
			
			$total = $this->calculateTotal($input['items']);

		} catch (Exception $e) {
			
			Log::error($e);

			$order->delete();

			return false;

		}

		//Charge card
		try {
			
			Stripe_Charge::create([

				'source' => $input['token']['id'],
				'amount' => $total,
				'currency' => 'usd',


			]);

		} catch (Exception $e) {
				
			Log::error($e);

			$order->delete();

			return false;

		}

		try {
			
			$this->assignOrderItems($input['items'], $order);

		} catch (Exception $e) {
			
			Log::error($e);

			$order->delete();

			return false;

		}

		try {
		
			//Queue Email
			Mail::send('emails.order', ['items' => $input['items'], 'info' => $input['form'], 'total' => $total], function($message) {

			    $message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New order from GATKU');

			});

		} catch (Exception $e) {
			
			Log::error($e);

			$order->delete();

			return false;

		}

		return true;

	}

	private function assignFields($order, $customer, $input) {


		$order->customerId = $customer->id;

		if($input['useBillingForShipping']) {

			$order->address = $input['address'];
			$order->city = $input['city'];
			$order->state = $input['state'];
			$order->country = $input['country'];
			$order->zip = $input['zip'];

		} else {

			$order->address = $input['shippingAddress'];
			$order->city = $input['shippingCity'];
			$order->state = $input['shippingState'];
			$order->country = $input['shippingCountry'];
			$order->zip = $input['shippingZip'];

		}

		return $order;



	}


	private function validateInput($input) {

		return true;

	}

	private function assignOrderItems($items, $order) {

		foreach($items as $item) {

			$orderItem = new OrderItem;
			$orderItem->orderId = $order->id;
			$orderItem->productId = $item['id'];
			$orderItem->save();

		}

	}

	private function calculateTotal($items) {

		$total = 0;

		foreach($items as $item) {

			$price = Product::findOrFail($item['id'])->price;

			// Log::info(P));

			$total += $price;

		}

		return $total;

	}


}