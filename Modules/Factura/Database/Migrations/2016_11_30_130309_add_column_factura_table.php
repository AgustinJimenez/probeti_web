<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnFacturaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura__facturas', function(Blueprint $table)
        {
            $table->string('nro_factura');
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
            $table->dropColumn('nro_factura');
        });
    }

}
