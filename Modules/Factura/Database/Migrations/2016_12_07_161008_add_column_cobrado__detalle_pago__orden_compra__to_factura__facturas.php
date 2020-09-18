<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCobradoDetallePagoOrdenCompraToFacturaFacturas extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura__facturas', function(Blueprint $table)
        {
            $table->boolean('cobrado');
            $table->string('detalle_pago');
            $table->string('orden_compra');
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
            $table->dropColumn('cobrado');
            $table->dropColumn('detalle_pago');
            $table->dropColumn('orden_compra');
        });
    }

}
