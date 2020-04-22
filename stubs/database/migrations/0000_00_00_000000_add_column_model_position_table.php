<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumn{{ UCPNAME }}PositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('{{ PNAME }}', function (Blueprint $table)
        {
            $table->integer('position')->after('id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('{{ PNAME }}', function (Blueprint $table)
        {
            $table->dropColumn('position');
        });
    }
}
