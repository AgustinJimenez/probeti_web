<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPiezaEstructuralToRemisionDetalle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->string('pieza_estructural');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->dropColumn('pieza_estructural');
        });
    }

}
