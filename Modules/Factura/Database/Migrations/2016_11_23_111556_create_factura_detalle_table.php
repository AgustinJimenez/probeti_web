<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaDetalleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura__detalle', function(Blueprint $table)
        {
            $table->increments('id');
            $table->double('cantidad', 8, 3);
            $table->string('descripcion', 1024);
            $table->integer('precio_unitario');
            $table->bigInteger('precio');
            $table->bigInteger('sub_total');
            $table->integer('iva');
            $table->integer('factura_id')->unsigned();
            $table->timestamps();

            $table->foreign('factura_id')->references('id')->on('factura__facturas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('factura__detalle');
    }

}
