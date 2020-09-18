<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaFacturasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factura__facturas', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('razon_social');
            $table->string('ruc');
            $table->date('fecha');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('forma_de_pago');
            $table->bigInteger('monto_total');
            $table->string('monto_total_letras');
            $table->bigInteger('iva_5_total');
            $table->bigInteger('iva_10_total');
            $table->bigInteger('iva_total');
            $table->boolean('anulado');
            $table->string('observacion')->nullable();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factura__facturas');
	}
}
