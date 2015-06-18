<?php

class ShippingRequest extends Eloquent {
	
	protected $table = 'shipping_requests';

	public function order() {

		return $this->belongsTo('order', 'orderId');

	}

}