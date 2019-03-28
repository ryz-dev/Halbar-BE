<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('flag_category')->after('description')->nullable();
            $table->enum('type', ['pages','posts','opd'])->after('flag_category')->nullable();
            $table->integer('category_id')->after('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('flag_category');
            $table->dropColumn('type');
            $table->dropColumn('category_id');
        });
    }
}
