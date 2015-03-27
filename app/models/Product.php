<?php

class Product extends Eloquent {

	protected $fillable = [];


	public function type() {

		return $this->belongsTo('ProductType', 'productType');

	}

}