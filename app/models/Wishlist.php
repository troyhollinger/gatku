<?php

class Wishlist extends Eloquent {

	protected $fillable = [];

	public function items() {

		return $this->hasManyThrough('Product', 'WishlistItem', 'wishlistId', 'productId');

	}

}