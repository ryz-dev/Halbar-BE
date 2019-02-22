<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesAboutTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages_about', function (Blueprint $table) {
			$table->longtext('about');
			$table->date('founded');
			$table->string('industry');
			$table->longtext('vision');
			$table->longtext('mission');
			$table->longtext('maps')->nullable();
			$table->text('image');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages_about');
	}
}
