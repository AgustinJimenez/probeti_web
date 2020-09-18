<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsDiametroEtiquetaToObras extends Migration 
{   

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obras__obras', function(Blueprint $table)
        {
            $table->string('diametro')->default('15');
            $table->string('etiqueta')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obras__obras', function(Blueprint $table)
        {
            $table->dropColumn('diametro');
            $table->dropColumn('etiqueta');

        });
    }

}
