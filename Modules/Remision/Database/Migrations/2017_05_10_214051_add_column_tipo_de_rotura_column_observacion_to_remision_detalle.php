<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTipoDeRoturaColumnObservacionToRemisionDetalle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->enum('tipo_rotura',['A','B','C','D','E','F','G'])->nullable();
            $table->string('observacion', 120)->nullable();
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
            $table->dropColumn('tipo_rotura');
            $table->dropColumn('observacion');
        });
    }

}
