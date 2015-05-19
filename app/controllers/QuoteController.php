<?php


class QuoteController extends BaseController {

	public function index() {

		return View::make('pages.quote');

	}

	public function sendEmail() {

		$form = Input::all();
		$name = Input::get('name');

		Mail::send('emails.inquiry', array('form' => $form), function($message) use ($name) {

		    $message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New Shipping Inquiry from ' . $name);

		});

	} 

}