<?php namespace Austen\Repositories;

use Order;
use OrderItem;
use Stripe_Charge;
use Product;
use Austen\Repositories\CustomerRepository;
use Log;
use Mail;
use OrderItemAddon;




/**
 *
 *
 * @todo complete validateInput method
 */
class OrderRepository {

	protected $customer;

	public function __construct(CustomerRepository $customer) {

		$this->customer = $customer;

	}

	public function all() {

		$orders = Order::with('items.addons.product', 'items.product', 'customer')->get();

		$orders = $this->assignHumanReadableTimestamps($orders);

		return $orders;

	}

	public function process($input) {

		// validate input
		if (!$this->validateInput($input)) {

			return false;

		}	

		try {
			
			$customer = $this->customer->store($input['form']);

			//create order object
			$order = new Order;
			//assign form data
			$order = $this->assignFields($order, $customer, $input['form']);

			// save order
			$order->save();

			//calculate total			
			$total = $this->calculateTotal($input['items']);

			//Charge card	
			Stripe_Charge::create([

				'source' => $input['token']['id'],
				'amount' => $total,
				'currency' => 'usd',

			]);
	
			$this->assignOrderItems($input['items'], $order);

			//Queue Email
			Mail::send('emails.order', ['items' => $input['items'], 'info' => $input['form'], 'total' => $total], function($message) {

			    $message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New order from GATKU');

			});

		} catch(Exception $e) {

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

	// TODO: Validate input
	private function validateInput($input) {

		return true;

	}

	private function assignOrderItems($items, $order) {

		foreach($items as $item) {

			$orderItem = new OrderItem;
			$orderItem->orderId = $order->id;
			$orderItem->productId = $item['id'];
			$orderItem->save();

			foreach($item['addons'] as $addon) {

				$itemAddon = new OrderItemAddon;
				$itemAddon->orderItemId = $orderItem->id;
				$itemAddon->productId = $addon['id'];
				$itemAddon->save();

			}

		}

	}

	/**
	 * 
	 *
	 * @todo calculate Shipping
	 */
	private function calculateTotal($items) {

		$total = 0;

		foreach($items as $item) {

			$price = Product::findOrFail($item['id'])->price;

			$total += $price;

			// The 'id' key of the $addon array is the id of the product in the products table,
			// NOT the id of the record in the addons table.
			foreach($item['addons'] as $addon) {

				$addonPrice = Product::findOrFail($addon['id'])->price;

				$total += $addonPrice;

			}

		}

		return $total;

	}

	private function assignHumanReadableTimestamps($collection) {

		foreach($collection as $model) {

			$model->createdAtHuman = $model->created_at->timezone('America/Los_Angeles')->format('F jS Y h:i A');

		}

		return $collection;

	}


}