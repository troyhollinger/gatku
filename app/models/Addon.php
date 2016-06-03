<?php

class Addon extends Eloquent {

	protected $fillable = [];

	public function product() {

		return $this->belongsTo('Product', 'childId');

	}
	
	
}