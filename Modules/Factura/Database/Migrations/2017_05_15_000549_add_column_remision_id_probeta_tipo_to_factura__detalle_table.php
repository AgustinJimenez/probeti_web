<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRemisionIdProbetaTipoToFacturaDetalleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura__detalle', function(Blueprint $table)
        {
            $table->integer('remision_id')->unsigned()->nullable()->index();
            $table->foreign('remision_id')->references('id')->on('remision__remisions');
            $table->enum('probeta_tipo',['chica', 'mediana', 'grande'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura__detalle', function(Blueprint $table)
        {
            $table->dropColumn('remision_id');
            $table->dropColumn('probeta_tipo');
        });
    }

}
