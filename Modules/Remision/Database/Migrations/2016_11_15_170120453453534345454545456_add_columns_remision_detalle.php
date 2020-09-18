<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsRemisionDetalle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->date('fecha_rotura');
            $table->string('carga_aplicada')->nullable();
            $table->string('resistencia')->nullable();
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
            $table->dropColumn('fecha_rotura');
            $table->dropColumn('carga_aplicada');
            $table->dropColumn('resistencia');
        });
    }

}
