<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAlturaPesoToRemisionDetalle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remision__detalle', function(Blueprint $table)
        {
            $table->double('altura', $total_char = 12, $decimales = 3)->nullable();
            $table->double('peso', $total_char = 12, $decimales = 3)->nullable();
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
            $table->dropColumn('altura');
        });
    }

}
