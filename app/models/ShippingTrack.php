<?php

class ShippingTrack extends Eloquent {
    
	protected $table = 'shipping_tracks';

	public function order() {

		return $this->belongsTo('Order', 'orderId');

	}
}