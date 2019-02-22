<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesImagesTable extends Migration
{
    public function up()
    {
      Schema::create('galleries_images', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('id_albums');
        $table->text('file_name');
        $table->string('dir',30);
      });
    }

    public function down()
    {
      Schema::drop('galleries_images');
    }
}
