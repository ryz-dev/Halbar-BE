<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('id_user');
			$table->text('slug');
			$table->text('title');
			$table->longText('content');
			$table->string('keyword', 250)->nullable();
			$table->text('image')->nullable();
			$table->string('category', 10);
			$table->enum('comment', ['0', '1']);
			$table->enum('status', ['publish', 'schedule', 'draft', 'hidden']);
			$table->dateTime('published');
			$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			$table->softDeletes();
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
