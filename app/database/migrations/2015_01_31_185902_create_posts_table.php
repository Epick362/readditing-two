<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name')->index();
			$table->string('url')->nullable()->index();
			
			$table->string('title');
			$table->string('author');
			$table->string('channel');
			$table->string('source')->nullable();

			$table->text('content')->nullable();

			$table->boolean('nsfw');
			$table->integer('comments');
			$table->integer('score');

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
		Schema::drop('posts');
	}

}
