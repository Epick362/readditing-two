<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMultiUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('multi_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('multi_id')->unsigned()->index();
			$table->foreign('multi_id')->references('id')->on('multis')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('multi_user');
	}

}
