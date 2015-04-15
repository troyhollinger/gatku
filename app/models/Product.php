<?php

class Product extends Eloquent {

	protected $fillable = [];


	public function type() {

		return $this->belongsTo('ProductType', 'typeId');

	}

	public function addons() {

		return $this->hasMany('Addon', 'parentId');

	}


}