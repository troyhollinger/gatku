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

    static public function orderItemsWithParams($startDate, $endDate) {
        return function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', array($startDate, $endDate));
        };
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