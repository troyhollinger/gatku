<?php

namespace Austen\Repositories;

use Illuminate\Support\ServiceProvider;


class BackendServiceProvider extends ServiceProvider {

	public function register() {

		$this->app->bind(

			'Pioneer\Repositories\ProductRepositoryInterface',
			'Pioneer\Repositories\ProductRepository'

		);

	}

}