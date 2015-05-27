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

				$order->save();
			
				$that->assignOrderItems($order, $input['items']);

				$order->load('items.addons.product.type','items.addons.size', 'items.product.type', 'customer', 'items.size');

				$subtotal = $that->calculateSubTotal($order);

				$shipping = $that->calculateShipping($order);

				$total = $that->calculateTotal($order);

				Stripe_Charge::create([

					'source' => $input['token']['id'],
					'amount' => $total,
					'currency' => 'usd',
					'description' => 'Order : ' . $order->number

				]);

				$date = Carbon::now()->timezone('America/Los_Angeles')->format('F jS Y | g:i A T');

				Mail::queue('emails.order', ['order' => $order, 'shipping' => $shipping, 'total' => $total, 'date' => $date], function($message) use ($customer){

					$message->to($customer->email, $customer->fullName)->subject('GATKU | Order Confirmation');
				  
				});

				Mail::queue('emails.order', ['order' => $order, 'shipping' => $shipping, 'total' => $total, 'date' => $date], function($message) {

					$message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New order from GATKU');
				  
				});

				Mail::queue('emails.order', ['order' => $order, 'shipping' => $shipping, 'total' => $total, 'date' => $date], function($message) {

					$message->to('emailme@troyhollinger.com', 'Troy Hollinger')->subject('New order from GATKU');
				  
				});

			});
			
		} catch(Exception $e) {

			return false;

		}

		return true;

	}

	/**
	 * Assigns the order destination fields
	 *
	 * @param $order $customer $input
	 * @return Eloquent Object $order
	 */
	private function assignFields($order, $customer, $input) {

		$order->customerId = $customer->id;
		$order->address = $input['address'];
		$order->city = $input['city'];
		$order->state = $input['state'];
		$order->country = $input['country'];
		$order->zip = $input['zip'];
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



	private function calculateSubTotal($order) {

		$subtotal = 0;

		$items = $order->items;

		foreach($items as $item) {

			if ($item->product->sizeable && $item->sizeId) {

				$price = $item->size->price;

			} else {

				$price = $item->product->price;
		
			}

			$price = $price * $item->quantity;

			$subtotal += $price;

			foreach($item->addons as $addon) {

				if ($addon->product->sizeable && $addon->sizeId) {

					$addonPrice = $addon->size->price;

				} else {

					$addonPrice = $addon->product->price;

				}

				$addonPrice = $addonPrice * $addon->quantity;

				$subtotal += $addonPrice;

			}

		}

		return $subtotal;

	}



	/**
	 * Calculate the shipping.
	 * There is a similar method in the CartController.js file. These two methods
	 * should produce identical results. 
	 *
	 */
	private function calculateShipping($order) {

		$shippingPrice = 0;
		$poles = [];
		$heads = [];
		$others = [];

		$items = $order->items;

		if ($this->calculateSubTotal($order) >= 30000) return 0;

		foreach($items as $item) {

			if ($item->product->type->slug === 'pole') {

				$poles[] = $item;

			} elseif ($item->product->type->slug === 'head') {

				$heads[] = $item;

			} else {

				$others[] = $item;
			}
		}

		if (count($poles) > 0) {

			$poleShippingPrice = $poles[0]->product->type->shippingPrice;

			if (count($poles) > 1) {

				$shippingPrice = $poleShippingPrice * count($poles);

			} else {

				$shippingPrice = $poleShippingPrice;

			}

		} elseif (count($heads) > 0) {

			$headShippingPrice = $heads[0]->product->type->shippingPrice;

			if (count($heads) > 1) {

				$shippingPrice = $headShippingPrice * ceil(count($heads) / 2);

			} else {

				$shippingPrice = $headShippingPrice;

			}

		} elseif (count($others) > 0) {

			$shippingPrice = $others[0]->product->type->shippingPrice;

		}

		return $shippingPrice;

	}

	private function calculateTotal($order) {

		$subtotal = $this->calculateSubTotal($order);

		$shipping = $this->calculateShipping($order);

		$total = $subtotal + $shipping;

		return $total;

	}

	/**
	 * Converts cart items to order Items, 
	 * Addons the same.
	 *
	 */
	private function assignOrderItems($order, $items) {

		foreach($items as $item) {

			$orderItem = new OrderItem;
			$orderItem->orderId = $order->id;
			$orderItem->productId = $item['id'];
			$orderItem->quantity = $item['quantity'];

			if ($item['sizeable'] && $item['sizeId']) {
				$orderItem->sizeId = $item['sizeId'];
			}

			$orderItem->save();

			foreach($item['addons'] as $addon) {

				$itemAddon = new OrderItemAddon;
				$itemAddon->orderItemId = $orderItem->id;
				$itemAddon->productId = $addon['id'];
				$itemAddon->quantity = $addon['quantity'];
				if($addon['sizeable'] && $addon['sizeId']) {

					$itemAddon->sizeId = $addon['sizeId'];

				}

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