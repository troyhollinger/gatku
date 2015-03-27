<?php

class Order extends Eloquent {

	protected $fillable = [];

	public function items() {

		return $this->hasManyTrough('Product', 'OrderItem', 'orderId', 'productId');

	}

	public function customer() {

		return $this->belongsTo('Customer', 'customerId');

	}

}