<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesAboutTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_about_team', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('position', 100);
            $table->string('phone', 20);
            $table->string('email', 150);
            $table->text('biografi')->nullable();
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
        Schema::drop('pages_about_team');
    }
}
