<?php


class OrderItemAddon extends Eloquent {

	protected $table = 'order_item_addons';

	public function product() {

		return $this->belongsTo('Product', 'productId');

	}


}