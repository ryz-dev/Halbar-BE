<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('informer_fullname', 150)->nullable();
            $table->string('informer_address')->nullable();
            $table->string('informer_email', 100)->nullable();
            $table->string('informer_phone', 20)->nullable();
            $table->string('suspect_fullname', 150)->nullable();
            $table->string('suspect_department', 100)->nullable();
            $table->string('suspect_division', 100)->nullable();
            $table->string('subject')->nullable();
            $table->longtext('complaint');
            $table->enum('read_status', ['0','1']);
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
        Schema::table('pengaduan', function (Blueprint $table) {
            Schema::drop('pengaduan');
        });
    }
}
