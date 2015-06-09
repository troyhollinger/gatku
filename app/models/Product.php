<?php

class Product extends Eloquent {

	protected $fillable = [];


	public function type() {

		return $this->belongsTo('ProductType', 'typeId');

	}

	public function addons() {

		return $this->hasMany('Addon', 'parentId');

	}

	public function images() {

		return $this->hasMany('YouImage', 'productId', 'id');

	}

	public function sizes() {

		return $this->hasMany('Size', 'productId', 'id');

	}

	public function availability() {

		return $this->hasOne('AvailabilityType', 'id', 'availabilityTypeId');

	}


}