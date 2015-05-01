<?php

// Composer: "fzaninotto/faker": "v1.3.0"


class SizesTableSeeder extends Seeder {

	public function run() {
		
		Size::create(['name' => 'Small', 'slug' => 'small']);
		Size::create(['name' => 'Medium', 'slug' => 'medium']);
		Size::create(['name' => 'Large', 'slug' => 'large']);
		Size::create(['name' => 'X Large', 'slug' => 'xlarge']);
		Size::create(['name' => 'XX Large', 'slug' => 'xxlarge']);




	}

}