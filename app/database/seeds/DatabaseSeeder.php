<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AvailabilityTypesTableSeeder');
		$this->call('ProductTypesTableSeeder');
		$this->call('ProductsTableSeeder');
		$this->call('SizesTableSeeder');
		$this->call('AddonsTableSeeder');
	}

}
