<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MobileHamburgerMenuAndCartButtonColor extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('home_settings', function(Blueprint $table)
		{
			
			$table->string('hamburger_menu_color')->nullable();
			$table->string('cart_button_color')->nullable();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('home_settings', function(Blueprint $table)
		{
			$table->dropColumn('hamburger_menu_color');
			$table->dropColumn('cart_button_color');
		});
	}

}
