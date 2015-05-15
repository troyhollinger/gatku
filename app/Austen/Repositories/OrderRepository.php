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
use Carbon\Carbon;

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

		$orders = Order::with('items.addons.product', 'items.product', 'customer', 'items.size')->orderBy('created_at', 'desc')->get();

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

			$that = $this;
			
			DB::transaction(function() use ($input, $that) {

				$customer = $that->customer->store($input['form']);

				$order = new Order;
				
				$order = $that->assignFields($order, $customer, $input['form']);

				// $items = $that->convertItemsToEloquent($input['items']);

				$shipping = $that->calculateShipping($input['items']);
				
				$total = $that->calculateTotal($input['items']);

				$order->save();

				// Assign current order as class property for use in other methods.
				$that->order = $order;

				$that->assignOrderItems($input['items']);

				Stripe_Charge::create([

					'source' => $input['token']['id'],
					'amount' => $total,
					'currency' => 'usd',
					'description' => 'Order : ' . $order->number

				]);

				$order->load('items.addons.product', 'items.product', 'customer', 'items.size');

				$date = Carbon::now()->timezone('America/Los_Angeles')->format('F jS Y | g:i A T');

				//Queue Email
				Mail::send('emails.order', ['order' => $order, 'shipping' => $shipping, 'total' => $total, 'date' => $date], function($message) {

				    $message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New order from GATKU');

				});

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

		$order->number = strtoupper(str_random(15));

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
	 * Calculate the shipping.
	 * There is a similar method in the CartController.js file. These two methods
	 * should produce identical results. 
	 *
	 */
	private function calculateShipping($items) {

		$shippingPrice = 0;
		$poles = [];
		$heads = [];
		$others = [];

		foreach($items as $item) {

			if ($item['type']['slug'] === 'pole') {

				$poles[] = $item;

			} elseif ($item['type']['slug'] === 'head') {

				$heads[] = $item;

			} else {

				$others[] = $item;

			}

		}

		if (count($poles) > 0) {

			$poleShippingPrice = $poles[0]['type']['shippingPrice'];

			if (count($poles) > 1) {

				$shippingPrice = $poleShippingPrice * count($poles);

			} else {

				$shippingPrice = $poleShippingPrice;

			}

		} elseif (count($heads) > 0) {

			$headShippingPrice = $heads[0]['type']['shippingPrice'];

			if (count($heads) > 1) {

				$shippingPrice = $headShippingPrice * ceil(count($heads) / 2);

			} else {

				$shippingPrice = $headShippingPrice;

			}

		} elseif (count($others) > 0) {

			$shippingPrice = $others[0]['type']['shippingPrice'];

		}

		return $shippingPrice;

	}


	/**
	 * 
	 *
	 * @todo calculate Shipping
	 */
	private function calculateTotal($items) {

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

		$shipping = $this->calculateShipping($items);

		$total = $total + $shipping;

		return $total;

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

	// private function convertItemsToEloquent($items) {

	// 	$collection = [];

	// 	foreach($items as $item) {

	// 		$model = Product::findOrFail($item['id']);
	// 		$model->load('type');
	// 		$model->addons = [];

	// 		foreach($item['addons'] as $addon) {

	// 			$modelAddon = Product::findOrFail($addon['id']);

	// 			$model->addons[] = $modelAddon;

	// 		}

	// 		$collection[] = $model;

	// 	}

	// 	return $collection;

	// }

	private function assignHumanReadableTimestamps($collection) {

		foreach($collection as $model) {

			$model->createdAtHuman = $model->created_at->timezone('America/Los_Angeles')->format('F jS Y | g:i A');

		}

		return $collection;

	}

}