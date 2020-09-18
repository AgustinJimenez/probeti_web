<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableClientes extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes__clientes', function(Blueprint $table)
        {
            $table->string('razon_social');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes__clientes', function(Blueprint $table)
        {
            $table->dropColumn('razon_social');
        });
    }

}
