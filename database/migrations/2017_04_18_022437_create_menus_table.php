<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function (Blueprint $table) {
			$table->increments('id');
			$table->string('menu_title', 50);
			$table->text('url');
			$table->integer('parent');
			$table->longText('description');
			$table->enum('status', ['header', 'footer']);
			$table->string('image', 30);
			$table->integer('sort')->default(999);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menus');
	}
}
