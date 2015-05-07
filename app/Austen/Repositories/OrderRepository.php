<?php namespace Austen\Repositories;

use Order;
use OrderItem;
use Stripe_Charge;
use Product;
use Austen\Repositories\CustomerRepository;
use Log;
use Mail;
use OrderItemAddon;
use Size;
use DB;

/**
 *
 *
 * @todo complete validateInput method
 */
class OrderRepository {

	protected $customer;

	protected $order;

	public function __construct(CustomerRepository $customer) {

		$this->customer = $customer;

	}

	public function all() {

		$orders = Order::with('items.addons.product', 'items.product', 'customer', 'items.size')->get();

		$orders = $this->assignHumanReadableTimestamps($orders);

		return $orders;

	}


	/**
	 * Processes order, payment, and email.
	 *
	 * @return boolean
	 */
	public function process($input) {

		if (!$this->validateInput($input)) {

			return false;

		}	

		try {
			
			DB::transaction(function() {

				$customer = $this->customer->store($input['form']);

				$order = new Order;
				
				$order = $this->assignFields($order, $customer, $input['form']);
				
				$total = $this->calculateTotal($input['items']);

				$order->save();

				// Assign current order as class property for use in other methods.
				$this->order = $order;

				$this->assignOrderItems($input['items']);

				Stripe_Charge::create([

					'source' => $input['token']['id'],
					'amount' => $total,
					'currency' => 'usd',

				]);

			});
			
			//Queue Email
			Mail::send('emails.order', ['items' => $input['items'], 'info' => $input['form'], 'total' => $total], function($message) {

			    $message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New order from GATKU');

			});

		} catch(Exception $e) {

			return false;

		}

		return true;

	}

	/**
	 * If user has checked useBillingForShipping box in cart, 
	 * replicate billing info, if not, assign the shipping information
	 * accordingly
	 */
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

	/**
	 * Validates the input from the cart. Make sure no shady business is happening.
	 *
	 * @todo code this method to validate the input 
	 */
	private function validateInput($input) {

		return true;

	}


	/**
	 * 
	 *
	 * @todo calculate Shipping
	 */
	private function calculateTotal($items) {

		try {
			
			$total = 0;

			foreach($items as $item) {

				if ($item['sizeable'] && $item['sizeId']) {

					$price = Size::findOrFail($item['sizeId'])->price;

				} else {

					$price = Product::findOrFail($item['id'])->price;

				}

				$total += $price;

				// The 'id' key of the $addon array is the id of the product in the products table,
				// NOT the id of the record in the addons table.
				foreach($item['addons'] as $addon) {

					$addonPrice = Product::findOrFail($addon['id'])->price;

					$total += $addonPrice;

				}

			}

			return $total;

		} catch (Exception $e) {
			
			Log::error($e);

			$this->order->delete();

			return false;

		}

	}

	/**
	 * Converts cart items to order Items, 
	 * Addons the same.
	 *
	 */
	private function assignOrderItems($items) {

		$order = $this->order;

		foreach($items as $item) {

			$orderItem = new OrderItem;
			$orderItem->orderId = $order->id;
			$orderItem->productId = $item['id'];

			if ($item['sizeable'] && $item['sizeId']) {
				$orderItem->sizeId = $item['sizeId'];
			}

			$orderItem->save();

			foreach($item['addons'] as $addon) {

				$itemAddon = new OrderItemAddon;
				$itemAddon->orderItemId = $orderItem->id;
				$itemAddon->productId = $addon['id'];

				$itemAddon->save();

			}

		}

	}

	private function assignHumanReadableTimestamps($collection) {

		foreach($collection as $model) {

			$model->createdAtHuman = $model->created_at->timezone('America/Los_Angeles')->format('F jS Y | g:i A');

		}

		return $collection;

	}

}