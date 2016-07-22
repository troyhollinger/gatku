<?php

class Product extends Eloquent {

	protected $fillable = [];


	public function type() {

		return $this->belongsTo('ProductType', 'typeId');

	}

	public function addons() {

		return $this->hasMany('Addon', 'parentId');

	}
	public function orderitems() {

		return $this->hasMany('OrderItem', 'productId');

	}

	public function images() {

		return $this->hasMany('YouImage', 'productId', 'id')->orderBy('created_at', 'desc');

	}

	public function sizes() {

		return $this->hasMany('Size', 'productId', 'id');

	}

	public function availability() {

		return $this->belongsTo('AvailabilityType', 'availabilityTypeId');

	}


}