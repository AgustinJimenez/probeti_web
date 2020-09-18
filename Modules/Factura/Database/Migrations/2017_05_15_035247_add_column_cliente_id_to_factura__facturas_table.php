<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnClienteIdToFacturaFacturasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura__facturas', function(Blueprint $table)
        {
            $table->integer('cliente_id')->unsigned()->index();
            $table->foreign('cliente_id')->references('id')->on('clientes__clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura__facturas', function(Blueprint $table)
        {
            $table->dropColumn('cliente_id');
        });
    }

}
