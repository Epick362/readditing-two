<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_settings', function(Blueprint $table)
		{
        	$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('user')->references('name')->on('users')->onDelete('cascade');

			$table->string('setting');
			$table->boolean('value');

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
		Schema::drop('users_settings');
	}

}
