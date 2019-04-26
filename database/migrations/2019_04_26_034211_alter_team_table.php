<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages_about_team', function (Blueprint $table) {
            $table->string('tempat_lahir')->after('nip')->nullable();
            $table->date('tanggal_lahir')->after('tempat_lahir')->nullable();
            $table->string('agama')->after('tanggal_lahir')->nullable();
            $table->string('pendidikan_terakhir')->after('agama')->nullable();
            $table->string('masa_bakti')->after('pendidikan_terakhir')->nullable();
            $table->string('alamat_rumah')->after('masa_bakti')->nullable();
            $table->string('alamat_kantor')->after('alamat_rumah')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages_about_team', function (Blueprint $table) {
            $table->dropColumn('nip');
            $table->dropColumn('tempat_lahir');
            $table->dropColumn('tanggal_lahir');
            $table->dropColumn('agama');
            $table->dropColumn('pendidikan_terakhir');
            $table->dropColumn('masa_bakti');
            $table->dropColumn('alamat_rumah');
            $table->dropColumn('alamat_kantor');
        });
    }
}
