<?php

class Order extends Eloquent {
	protected $fillable = [];

	public function items() {
		return $this->hasMany('OrderItem', 'orderId');
	}

	public function customer() {
		return $this->belongsTo('Customer', 'customerId');
	}
}