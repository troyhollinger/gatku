<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	protected $fillable = ['firstName', 'lastName', 'fullName', 'password', 'email'];


	public function customer() {

		return $this->belongsTo('Customer', 'customerId');

	}

	public function wishlist() {

		return $this->hasOne('Wishlist', 'userId');

	}


}
