<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJeniKelaminToTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages_about_team', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['Laki - laki', 'Perempuan'])->after('tanggal_lahir');
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
            $table->dropColumn('jenis_kelamin');
        });
    }
}
