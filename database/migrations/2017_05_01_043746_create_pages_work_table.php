<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesWorkTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages_work', function (Blueprint $table) {
			$table->increments('id');
			$table->text('slug');
			$table->integer('sort');
			$table->string('title', 250);
			$table->text('shortdesc')->nullable();
			$table->longtext('content');
			$table->string('tag', 250);
			$table->string('category', 50)->nullable();
			$table->text('image');
			$table->text('link');
			$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages_work');
	}
}
