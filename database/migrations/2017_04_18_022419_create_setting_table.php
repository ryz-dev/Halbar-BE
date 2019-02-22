<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('setting', function (Blueprint $table) {
			$table->string('meta_title', 50);
			$table->text('meta_description');
			$table->string('meta_keyword', 250);
			$table->string('timezone', 30);
			$table->string('email', 120);
			$table->string('phone', 25);
			$table->string('address', 250);
			$table->enum('maintenance', ['0', '1']);
			$table->text('logo');
			$table->text('favicon');
			$table->text('og_image');
			$table->string('key_token', 100);
			$table->string('facebook', 250)->nullable();
			$table->string('twitter', 250)->nullable();
			$table->string('google', 250)->nullable();
			$table->string('linkedin', 250)->nullable();
			$table->string('youtube', 250)->nullable();
			$table->string('instagram', 250)->nullable();
			$table->date('expired_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('setting');
	}
}
