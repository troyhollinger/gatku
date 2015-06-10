<?php


class QuoteController extends BaseController {

	public function index() {

		return View::make('pages.quote');

	}

	public function sendEmail() {

		$form = Input::all();
		$name = Input::get('name');

		if (App::environment('production')) {

			Mail::queue('emails.inquiry', array('form' => $form), function($message) use ($name) {

			    $message->to('dustin@gatku.com', 'GATKU Polespears')->subject('New Shipping Inquiry from ' . $name);

			});

		} 

		Mail::queue('emails.inquiry', array('form' => $form), function($message) use ($name) {

		    $message->to('austenpayan@gmail.com', 'Austen Payan')->subject('New Shipping Inquiry from ' . $name);

		});

	

	} 

}