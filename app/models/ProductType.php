<?php

class ProductType extends Eloquent {

	protected $table = 'product_types';

	protected $fillable = [];

	public function products() {
		return $this->hasMany('Product', 'typeId');
	}
}