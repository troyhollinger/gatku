<?php


class AuthenticationController extends BaseController {


	public function index() {

		return View::make('pages.login');

	}

	public function authenticate() {

		$email = Input::get('email');
		$password = Input::get('password');

		if(Auth::attempt(['email' => $email, 'password' => $password], true)) {

			if (Auth::user()->admin) {

				return Redirect::route('admin.index');

			} else {

				return Redirect::route('home');

			}

		} else {

			return Redirect::route('login.index');

		}

	}

	public function logout() {

		Auth::logout();

		return Redirect::route('home');

	}

}