<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('productType')->unsigned();
			$table->foreign('productType')->references('id')->on('product_types');
			$table->string('attachedImage')->nullable();
			$table->string('detachedImage')->nullable();
			$table->string('name');
			$table->string('shortName');
			$table->string('slug');
			$table->integer('price');
			$table->text('description');
			$table->text('maneuverability')->nullable();
			$table->text('trajectory')->nullable();
			$table->text('balance')->nullable();
			$table->text('stealth')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
