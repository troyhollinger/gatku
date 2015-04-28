<?php

class OrderItem extends Eloquent {

	protected $fillable = [];

	protected $table = 'order_items';

	public function addons() {

		return $this->hasMany('OrderItemAddon', 'orderItemId');

	}

	public function product() {

		return $this->belongsTo('Product', 'productId');

	}
	
}